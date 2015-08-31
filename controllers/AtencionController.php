<?php

namespace app\controllers;

use Yii;
use app\models\Procedimientos;
use app\models\Pacientes;
use app\models\ListasSistema;
use app\models\TiposServicio;
use app\models\Ciudades;
use app\models\Eps;
use app\models\Especialidades;
use app\models\Ips;
use app\models\Campos;
use app\models\Recibos;
use app\models\Usuarios;
use app\models\MedicosRemitentesIps;
use app\models\ProcedimientosSearch;
use app\models\VlrsCamposProcedimientos;
use app\models\MedicosRemitentes;
use app\models\PlantillasDiagnosticos;
use app\models\UsuariosIps;
use app\models\HistoriaClinica;
use app\models\CitasMedicas;
use app\models\Tarifas;
use app\models\MotivoEnfermedad;
use app\models\AntecedentesPatologicos;
use app\models\AntecedentesFamiliares;
use app\models\Habitos;
use app\models\RevSistemas;
use app\models\ExamenFisico;
use app\models\ExploracionRegional;
use app\models\AnalisisDiag;
use app\models\AnalisisImpresiondiagnostica;
use app\models\CodCie10;
use app\models\Recomendaciones;
use app\models\Formulacion;
use app\models\UploadForm;
use app\models\ArchivosHistorial;
use app\models\EpsTipos;
use app\models\EstudiosIps;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\db\Query;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use yii\web\JsExpression;

/**
 * ProcedimientosController implements the CRUD actions for Procedimientos model.
 */
class AtencionController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view', 'update','get-descripcion','nueva-plantilla','editar-plantilla','get-historia','new-for','upload','new-rec','new-an','new-exp','new-ex','new-rev','new-hab','new-fam','new-pat','new-mot','cod-diag'],
                        'roles' => ['medico'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','create','view','update','guardar-medico','add-medico','get-paciente','calcular-edad','calcular-fecha','pacientes-create','precio'],
                        'roles' => ['procedimientos'],
                    ],
                   
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Procedimientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcedimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lista_estados'=> ArrayHelper::map(ListasSistema::find()->where('tipo="estado_atencion"')->all(),'codigo','descripcion'),
        ]);
    }

    /**
     * Displays a single Procedimientos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Procedimientos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Procedimientos();
        if(isset($_GET['p']))
        {
            $paciente = Pacientes::findOne($_GET['p']);
        }else{

            $paciente = new Pacientes();
        }

        if ($model->load(Yii::$app->request->post()) && $paciente->load(Yii::$app->request->post()))
        {
            $tipo_serv = TiposServicio::findOne($model->idtipo_servicio);
            $model->usuario_recibe = Yii::$app->user->id;
            $model->numero_muestra = $tipo_serv->serie.$tipo_serv->consecutivo.'-'.date('y');
            $model->cantidad_muestras = 1;
            $model->periodo_facturacion = $model->fecha_atencion;
            $model->hora = $_POST['CitasMedicas']['hora_llegada'];
            $model->estado = 'ABT';

            $pac = Pacientes::find()->where(['identificacion'=>$paciente->identificacion])->one();

            if($pac == null)
            {
                $paciente->idclientes = Usuarios::findOne($model->usuario_recibe)->idclientes; 
                $paciente->activo = 1;
                if(!$paciente->save())
                {
                    return 0;
                }
                // $paciente->save();
                $model->idpacientes = $paciente->id;
            }else{
                if(!$pac->save())
                {
                    return 0;
                }
                $model->idpacientes = $pac->id;
            }
            
            if($model->save())
            {
                $sw = true;

                $cons = $tipo_serv->consecutivo + 1;
                if($model->epsIdeps->idips0->idclientes0->tipo_consecutivo == 'E')
                {
                    $tipo_serv->consecutivo = $cons;
                    $tipo_serv->save();
                }else{
                    $tipos = TiposServicio::find()->join('INNER JOIN', 'ips i', 'tipos_servicio.idips = i.id')
                    ->where(['i.idclientes'=>$model->epsIdeps->idips0->idclientes0->id])->andWhere(['tipos_servicio.serie'=>$tipo_serv->serie])->all();
                    foreach ($tipos as $t) {
                        $t->consecutivo = $cons;
                        $t->save();
                    }
                }

                $this->generarRecibo($model->id);

                $hc = new HistoriaClinica();
                $hc->id_paciente = $model->idpacientes;
                $hc->id_tipos = $model->idtipo_servicio;
                $hc->fecha = date('Y-m-d');
                $hc->hora = date('H:i:s');
                $hc->id_medico = $model->idmedico;
                $hc->id_procedimiento = $model->id;
                $hc->save();

                $cita = CitasMedicas::find()->where(['pacientes_id'=>$model->idpacientes, 'medicos_id'=>$model->idmedico, 'fecha'=>$model->fecha_atencion])->one();
                if($cita != null)
                {
                    $cita->hora_llegada = $_POST['CitasMedicas']['hora_llegada'];
                    $cita->estado = 'PRE';   
                    if(!$cita->save())
                    {
                        return 0;
                    }
                    $sw = false;
                }
                return $sw == true ? Yii::$app->request->baseUrl.'/atencion/index' : Yii::$app->request->baseUrl.'/citas-medicas/index';
                // return 1;
             
            }else{
                return 0;
            }
        }

         $js = <<< SCRIPT
            // $('.field-citasmedicas-hora_llegada').append('<a href="#" id="hora" class="btn btn-default">Colocar hora</a>');
            $(document).on('click', '#hora', function(event) {
                event.preventDefault();
                var hora = new Date();
                var hours = hora.getHours() < 10 ? '0' + hora.getHours() : hora.getHours();
                var minutes = hora.getMinutes() < 10 ? '0' + hora.getMinutes() : hora.getMinutes();
                var seconds = hora.getSeconds() < 10 ? '0' + hora.getSeconds() : hora.getSeconds();
                $('#citasmedicas-hora_llegada').val(hours+ ":" +minutes);
            });
            
SCRIPT;
        $ips_model = new Ips();
        $model->fecha_atencion = date('Y-m-d');
        $cita_model = new CitasMedicas();
        $cita_model->hora_llegada = date('H:i:s');
        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);//subquery
        // $lista_meds = (new Query())->select(['id'=>'medicos.id', 'nombre'=>'CONCAT(medicos.nombre, " - " ,especialidades.nombre)'])->from('medicos')
        //             ->join('INNER JOIN', 'especialidades', 'medicos.idespecialidades = especialidades.id')->where(['medicos.ips_idips'=>$id_ips])->all();
        $rango_fecha = $this->rangoFecha();

        $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
        return $this->render('create', [
            'model' => $model, 
            'paciente_model'=>$paciente,
            'ips_model'=> $ips_model,
            'ips_list'=>ArrayHelper::map(Ips::find()->all(),'id','nombre'),
            'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
            'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
            'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
            'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
            'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$id_ips])->all(),'id','nombre'),
            'lista_pago'=>ArrayHelper::map(ListasSistema::find()->where('tipo="forma_pago"')->all(),'codigo','descripcion'),
            'lista_med'=>ArrayHelper::map($this->getMedRemIps($id_ips),'id','nombre'),
            'rango_fecha'=>$rango_fecha,
            'cita_model'=> $cita_model,
        ]);
        
    }

    /**
     * Updates an existing Procedimientos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $paciente = Pacientes::findOne($model->idpacientes);
        $ips_model = Ips::findOne($model->epsIdeps->idips0->id);
        $cita = CitasMedicas::find()->where(['pacientes_id'=>$model->idpacientes, 'medicos_id'=>$model->idmedico, 'fecha'=>$model->fecha_atencion, 'hora'=>$model->hora])->one();

        if ($model->load(Yii::$app->request->post()) && $paciente->load(Yii::$app->request->post())) 
        {
            if(!$paciente->save())
            {
                return 0;
            }
            $model->periodo_facturacion = $model->fecha_atencion;
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }

        $js = <<< SCRIPT
            // $('.field-citasmedicas-hora_llegada').append('<a href="#" id="hora" class="btn btn-default">Colocar hora</a>');
            $(document).on('click', '#hora', function(event) {
                event.preventDefault();
                var hora = new Date();
                var hours = hora.getHours() < 10 ? '0' + hora.getHours() : hora.getHours();
                var minutes = hora.getMinutes() < 10 ? '0' + hora.getMinutes() : hora.getMinutes();
                // var seconds = hora.getSeconds() < 10 ? '0' + hora.getSeconds() : hora.getSeconds();
                $('#citasmedicas-hora_llegada').val(hours+ ":" +minutes);
            });
            
SCRIPT;

        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);//subquery
        $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            'paciente_model' => $paciente,
            'ips_model'=> $ips_model,
            'ips_list'=>ArrayHelper::map(Ips::find()->all(),'id','nombre'),
            'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
            'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
            'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
            'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
            'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$id_ips])->all(),'id','nombre'),
            'lista_pago'=>ArrayHelper::map(ListasSistema::find()->where('tipo="forma_pago"')->all(),'codigo','descripcion'),
            'lista_med'=>ArrayHelper::map($this->getMedRemIps($id_ips),'id','nombre'),
            'rango_fecha'=>$this->rangoFecha(),
            'cita_model'=>$cita == null ? new CitasMedicas() : $cita,
        ]);
        
    }

    public function actionGetHistoria()
    {
        $hc = HistoriaClinica::find()->select(['id','fecha'=>'DATE_FORMAT(fecha,"%d %b %y")'])->where(['id_paciente'=>$_POST['pac']]); //Se asume que existe una sola historia clinica por fecha
        $proc_fechas = Procedimientos::find()->select(['id','fecha_atencion'=>'DATE_FORMAT(fecha_atencion,"%d %b %y")'])->where(['idpacientes'=>$_POST['pac']]);
        $paciente = Pacientes::findOne($_POST['pac']);

        $historia = HistoriaClinica::find()->select(['id'])->where(['id_paciente'=>$_POST['pac']])->max('id');
        $historia_model = HistoriaClinica::findOne($historia);

        $tipo_estudio = TiposServicio::findOne($historia_model->id_tipos);

        $campos = Campos::find()->where(['idtipos_servicio'=>$tipo_estudio->id])->all();

        
        if($historia == null)
        {
            return 0;
        }

        return $this->renderAjax('//historia-clinica/medico',[
                'hc' => $historia,
                'pr' => $historia_model->id_procedimiento,
                'tipo_estudio' => $tipo_estudio,
                'paciente'=>$paciente,
                'campos' => $campos,
                'motivo_l'=>ArrayHelper::map($hc->having(['id'=> MotivoEnfermedad::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'motivo_e'=>new MotivoEnfermedad(),
                'ant_pato_l'=>ArrayHelper::map($hc->having(['id'=> AntecedentesPatologicos::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'ant_pato_e'=>new AntecedentesPatologicos(),
                'ant_fam_l'=> ArrayHelper::map($hc->having(['id'=> AntecedentesFamiliares::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'ant_fam_e'=>new AntecedentesFamiliares(),
                'habitos_l'=> ArrayHelper::map($hc->having(['id'=> Habitos::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'habitos_e'=>new Habitos(),
                'rev_sis_l'=> ArrayHelper::map($hc->having(['id'=> RevSistemas::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'rev_sis_e'=> new RevSistemas(),
                'exam_fis_l'=> ArrayHelper::map($hc->having(['id'=> ExamenFisico::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'exam_fis_e'=>new ExamenFisico(),
                'exp_reg_l'=> ArrayHelper::map($hc->having(['id'=> ExploracionRegional::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'exp_reg_e'=>new ExploracionRegional(),
                'analisis_l'=> ArrayHelper::map($hc->having(['id'=> AnalisisDiag::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'analisis'=>new AnalisisDiag(),
                'an_imp' => new AnalisisImpresiondiagnostica(),
                'recom_l' => ArrayHelper::map($hc->having(['id'=> Recomendaciones::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'recom_e' => new Recomendaciones(),
                'formula_l' => ArrayHelper::map($hc->having(['id'=> Formulacion::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'formula_e' => new Formulacion(),
                'archivo_historial' => new ArchivosHistorial(),
                'archivo_historial_l' => ArrayHelper::map($hc->having(['id'=> ArchivosHistorial::find()->select(['id_historia'])])->all(), 'id', 'fecha'),
                'archivo' => new UploadForm(),
                'nombre_pac'=>$paciente->nombre1. ' ' .$paciente->nombre2. ' ' .$paciente->apellido1. ' ' .$paciente->apellido2,
                'tipo_estudio_l' => ArrayHelper::map($proc_fechas->all(), 'id', 'fecha_atencion'),
            ]);
    }

    
    /**
     * Deletes an existing Procedimientos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletee($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Cambia el estado de una cita a cerrada.
     * @param integer $id
     * @return mixed
     */
    public function actionCerrarCita()
    {
        $cita = $this->findModel($_POST['id']);
        $cita->estado = 'CER';

        $cita_prog = CitasMedicas::find()->where(['pacientes_id'=>$cita->idpacientes, 'medicos_id'=>$cita->idmedico, 'fecha'=>$cita->fecha_atencion])->one();

        if($cita_prog !== null)
        {
            $cita_prog->estado = 'CLS';
            $cita_prog->save();
        }

        if($cita->save())
        {
            return 1;
        }else{
            return 0;
        }

    }

    /**
     * Finds the Procedimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Procedimientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Procedimientos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    public function generarRecibo($id)
    {
        $model = $this->findModel($id);
        $recibo = Recibos::find()->where(['idprocedimiento'=>$id, 'valor_saldo'=>$model->valor_saldo, 'valor_abono'=>$model->valor_abono])->one();
        if($recibo == null)
        {
            $recibo = new Recibos();
            $ips = Ips::findOne($model->epsIdeps->idips0->id);
            $recibo->num_recibo = $ips->consecutivo_recibo;
            $ips->consecutivo_recibo = $ips->consecutivo_recibo + 1;
            $ips->save();
            $recibo->idprocedimiento = $id;
            $recibo->valor_abono = $model->valor_abono;
            $recibo->valor_saldo = $model->valor_saldo;
            $recibo->idusuario = Yii::$app->user->id;
            $recibo->fecha = date('Y-m-d');
            $recibo->save();
        }
    }

    public function getMedRemIps($id_ips)
    {
        $query = new Query();
        $query->select(['id'=>'m.id', 'nombre'=>'CONCAT(m.nombre," - ",e.nombre)'])->from('especialidades e')
        ->join('INNER JOIN', 'medicos_remitentes m', 'm.especialidades_id = e.id')
        ->join('INNER JOIN', 'medicos_remitentes_ips r', 'r.medicos_remitentes_id = m.id')
        ->join('INNER JOIN', 'ips i', 'i.id = r.ips_id')
        ->where(['i.id'=>$id_ips]);

        return $query->all();
    }

    public function getMedRemGen()
    {
        $query = new Query();
        $query->select('(m.id) AS id, (m.nombre) AS nombre, (e.nombre) AS especialidad')->from('especialidades e')
        ->join('INNER JOIN', 'medicos_remitentes m', 'm.especialidades_id = e.id');

        return $query->all();
    }

    public function actionPaciente()
    {
        \Yii::$app->response->format = 'json';
        $paciente = Pacientes::find()->where(['identificacion'=>$_POST['data']])->one();

       return $paciente == null ? 0 : $paciente;
    }

    public function actionPrecio()
    {
        Yii::$app->response->format = 'json';
        $query = (new Query())->select('valor_procedimiento, descuento')->from('tarifas')->where(['idestudios'=>$_POST['cod'], 'eps_id'=>$_POST['id']]);
        return $query->one();
    }
    
    public function rangoFecha()
    {
        $fecha = date('Y');
        $fecha_min = strtotime('-95 year', strtotime($fecha));
        $fecha_max = strtotime('-0 year', strtotime($fecha));
        $fecha_min = date('Y', $fecha_min);
        $fecha_max = date('Y', $fecha_max);

        return $fecha_min.':'.$fecha_max;
    }

    /*Consulta de listados*/

    public function medicos($id_ips)
    {
        $query = (new Query())->select(['id'=>'id', 'name'=>'nombre'])->from('medicos')->where(['ips_idips'=>$id_ips]);
        return $query->all();
    }

    public function eps($id_ips)
    {
        $subquery = EpsTipos::find()->distinct()->select(['eps_id']);
        $subquery2 = Tarifas::find()->distinct()->select(['eps_id']);
        $query = (new Query());
        $query->select(['id'=>'id', 'name'=>'nombre'])->from('eps')->where(['idips'=>$id_ips])->andWhere(['id'=>$subquery])->andWhere(['id'=>$subquery2]);
        $r = $query->all();

        return $r;
    }

    public function tipos_s($id_ips, $id_eps)
    {
        $subquery2 = Tarifas::find()->distinct()->select(['idestudios'])->where(['eps_id'=>$id_eps]);
        $subquery = EstudiosIps::find()->distinct()->select(['idtipo_servicio'])->where(['cod_cups'=>$subquery2]);
        $query = (new Query());
        $query->select('ts.id,(ts.nombre)AS name')->from('tipos_servicio ts')
        ->join('INNER JOIN', 'eps_tipos ep','ep.tipos_servicio_id = ts.id')
        ->join('INNER JOIN', 'eps e','e.id = ep.eps_id')
        ->join('INNER JOIN', 'ips i','i.id = e.idips')
        ->where(['e.id'=>$id_eps])->andWhere(['ts.id'=>$subquery]);

        return $query->all();
    }


    public function estudio($id_ips, $id_eps, $id_tipo)
    {
        $tarifas = Tarifas::find()->select(['idestudios'])->where(['eps_id'=>$id_eps]);
        $query = (new Query());
        $query->select('(es.cod_cups)AS id, (es.descripcion)AS name')->from('estudios es')
        ->join('INNER JOIN', 'estudios_ips ei','ei.cod_cups = es.cod_cups')
        ->join('INNER JOIN', 'tipos_servicio ts','ts.id = ei.idtipo_servicio')
        ->join('INNER JOIN', 'eps_tipos et','et.tipos_servicio_id = ts.id')
        ->join('INNER JOIN', 'eps e','e.id = et.eps_id')
        ->join('INNER JOIN', 'ips i','i.id = e.idips')
        ->where(['i.id'=>$id_ips,'e.id'=>$id_eps, 'ts.id'=>$id_tipo])
        ->andWhere(['es.cod_cups'=>$tarifas]);

        return $query->all();
    }

     /*-----------------Dependencias---------------------*/
    public function actionSubmed() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $ips_id = $parents[0];
                $out = $this->medicos($ips_id);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }


    public function actionSubeps() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $ips_id = $parents[0];
                $out = $this->eps($ips_id);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionSubtipo() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $ips_id = empty($ids[0]) ? null : $ids[0];
            $eps_id = empty($ids[1]) ? null : $ids[1];
            if ($ips_id != null) {
               $data = self::tipos_s($ips_id, $eps_id);
                // $data =  [
                //        'out'=>[
                //            ['id'=>'1', 'name'=>'<prod-name1>'],
                //            ['id'=>'2', 'name'=>'<prod-name2>']
                //         ],
                //         'selected'=>'1'
                //    ];
                return Json::encode(['output'=>$data, 'selected'=>'']);
                // return Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }


    public function actionSubest() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $ips_id = empty($ids[0]) ? null : $ids[0];
            $eps_id = empty($ids[1]) ? null : $ids[1];
            $tipo_id = empty($ids[2]) ? null : $ids[2];
            if ($ips_id != null) {
               $data = self::estudio($ips_id, $eps_id, $tipo_id);

                return Json::encode(['output'=>$data, 'selected'=>'']);
                // return Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }


    public function actionImprimirRf($hc, $rf)
    {
        switch ($rf) 
        {
            case 'r':
                $model = Recomendaciones::find()->where(['id_historia'=>$hc])->one();
                $model = $model->recomendaciones;
                break;
            case 'f':
                $model = Formulacion::find()->where(['id_historia'=>$hc])->one();
                $model = $model->formulacion;
                break;
        }
        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;


        $mpdf->WriteHtml($this->render('//historia-clinica/recomFor', [
                'model' => $model,
            ], true));
        $mpdf->SetJS('this.print()');
        $mpdf->output();

    }



    public function actionCodDiag($q = null, $id = null)
    {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $query = new Query;
                $query->select(['id'=>'codigo', 'text'=>'CONCAT(codigo, "-" ,descripcion)'])
                    ->from('cod_cie10')
                    ->where(['like','CONCAT(codigo, "-" ,descripcion)',$q])
                    ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }
            elseif ($id > 0) {
                $cod = CodCie10::findOne($id);
                $out['results'] = ['id' => $id, 'text' => $cod->descripcion.' - '.$cod->descripcion];
            }
            return $out;
    }

    public function actionNewMot()
    {
        $model = new MotivoEnfermedad();
        if($model->load(Yii::$app->request->post()))
        {
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewPat()
    {
        $model = new AntecedentesPatologicos();
        if($model->load(Yii::$app->request->post()))
        {
            $i = 0;
            foreach ($model->fields() as $key => $value) {
                if($value != 'otros'){
                    $model->setAttributes([$value=>$_POST['sino'][$i].'-'.$model->getAttribute($value)]);
                    $i++;
                }
            }
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewFam()
    {
        $model = new AntecedentesFamiliares();
        if($model->load(Yii::$app->request->post()))
        {
            $i = 0;
            foreach ($model->fields() as $key => $value) {
                if($value != 'otros'){
                    $model->setAttributes([$value=>$_POST['sino_ant_fam'][$i].'-'.$model->getAttribute($value)]);
                    $i++;
                }
            }
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewHab()
    {
        $model = new Habitos();
        if($model->load(Yii::$app->request->post()))
        {
            $i = 0;
            foreach ($model->fields() as $key => $value) {
                if($value != 'otros'){
                    $model->setAttributes([$value=>$_POST['sino_habitos'][$i].'-'.$model->getAttribute($value)]);
                    $i++;
                }
            }
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewRev()
    {
        $model = new RevSistemas();
        if($model->load(Yii::$app->request->post()))
        {
            $i = 0;
            foreach ($model->fields() as $key => $value) {
                if($value != 'otros'){
                    $model->setAttributes([$value=>$_POST['sino_rev_sis'][$i].'-'.$model->getAttribute($value)]);
                    $i++;
                }
            }
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewEx()
    {
        $model = new ExamenFisico();
        if($model->load(Yii::$app->request->post()))
        {
            
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewExp()
    {
        $model = new ExploracionRegional();
        if($model->load(Yii::$app->request->post()))
        {
            $i = 0;
            foreach ($model->fields() as $key => $value) {
                $model->setAttributes([$value=>$_POST['sino_expl'][$i].'-'.$model->getAttribute($value)]);
                $i++;
            }
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewAn()
    {
        $analisis = new AnalisisDiag();
        

        if($analisis->load(Yii::$app->request->post()))
        {
            $analisis->id_historia = $_POST['historia_cli'];
            if($analisis->save())
            {
                foreach ($_POST['AnalisisImpresiondiagnostica']['id_cod'] as $key => $value) 
                {
                    $diagnosticos = new AnalisisImpresiondiagnostica();
                    $diagnosticos->id_analisis = $analisis->id;
                    $diagnosticos->id_cod = $value;
                    if(!$diagnosticos->save())
                    {
                        return 0;
                    }
                }
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewRec()
    {
        $model = new Recomendaciones();
        if(Yii::$app->request->post())
        {
            $model->recomendaciones = $_POST['Recomendaciones']['recomendaciones'];
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionNewFor()
    {
        $model = new Formulacion();
        if(Yii::$app->request->post())
        {
            $model->formulacion = $_POST['Formulacion']['formulacion'];
            $model->id_historia = $_POST['historia_cli'];
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function actionUpload()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) 
        {
            $model->files = UploadedFile::getInstances($model, 'files');
            // return json_encode($model->files);
            foreach ($model->files as $file) 
            {
                if($file->extension == 'exe')
                {
                    return 2;
                }
                $nombre = utf8_decode($file->baseName) . '.' . $file->extension;
                $file->saveAs('images/hist/' . $nombre);
                $archivo = new ArchivosHistorial();
                $archivo->archivo = $file->baseName . '.' . $file->extension;
                $archivo->id_historia = $_POST['historia_cli'];
                if(!$archivo->save())
                {
                    return 0;
                }
            }
            
            return 1;
        }
    }

    public function actionNewEspecialidad()
    {
        if(Yii::$app->request->post())
        {
            $i = 0;
            foreach ($_POST['TiposServicio'] as $clave => $val) 
            {
                if($clave != 'id_campo' && $clave != 'id')
                {
                    foreach ($_POST['TiposServicio'][$clave] as $key => $value) 
                    {
                        $valor = new VlrsCamposProcedimientos();
                        $valor->valor = $value;
                        $valor->idcampos_tipos_servicio = $_POST['TiposServicio']['id_campo'][$i];
                        $valor->id_procedimiento = $_POST['procedimiento_id'];
                        $valor->save();
                        $i++;
                    }
                }
            }
            return 1;
           
        }
    }
}
