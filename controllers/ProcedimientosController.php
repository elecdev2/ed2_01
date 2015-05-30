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


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\db\Query;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;

/**
 * ProcedimientosController implements the CRUD actions for Procedimientos model.
 */
class ProcedimientosController extends Controller
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
                        'actions' => ['index','create','view','update'],
                        'roles' => ['auxiliar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view', 'update'],
                        'roles' => ['medico'],
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
        $lista_estados = ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion');
        // if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lista_estados'=>$lista_estados,
            ]);
        // }else{
        //     return $this->render('index', [
        //         'searchModel' => $searchModel,
        //         'lista_estados'=>$lista_estados,
        //     ]);
        // }

    }

    /**
     * Displays a single Procedimientos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('view', [
            'model' => $model,
        ]);
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

    public function getRecibos($id)
    {
        $query = Recibos::find()->where(['idprocedimiento'=>$id]);

        $dataProvider = new ActiveDataprovider([
                'query'=>$query,
                'sort'=>false,
            ]);


        return $dataProvider;
    }

    public function actionGenerarRecibo($id, $vista)
    {

        if($vista == 1){
            $model = $this->findModel($id);
            $recibos = $this->getRecibos($id);
            return $this->renderAjax('recibo',[
                    'model'=>$model,
                    'recibos'=>$recibos,
                ]);
        }
        if($vista == 2){
            $model = Recibos::findOne($id);
        }else{
            $id = (new Query())->select('id')->from('recibos')->where(['idprocedimiento'=>$id])->max('id');
            $model = Recibos::findOne($id);
        }
        $this->layout = 'resultados_layout';
        $formato = [76,180];
        $contenido = $this->renderPartial('recibo_caja',[
                'model'=>$model,
            ],true);
        $css = '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css';
        $titulo = 'Recibo';

        $this->pdf($formato, $contenido, $css, $titulo);
    }

    /**
     * Creates a new Procedimientos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Procedimientos();
        $paciente = new Pacientes();
        $medicoRem = new MedicosRemitentes();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->estado = 'PND';
            $model->usuario_recibe = Yii::$app->user->id;
            $tipo_serv = $this->findModelTipos($model->idtipo_servicio);
            $model->numero_muestra = $tipo_serv->serie.$tipo_serv->consecutivo.'-'.date('y');
            $pac = $this->findModelPaciente($model->idpacientes);
            if($paciente->load(Yii::$app->request->post()))
            {
                $pac->tipo_identificacion = $paciente->tipo_identificacion != '' ? $paciente->tipo_identificacion : $pac->tipo_identificacion;
                $pac->nombre1 = $paciente->nombre1;
                $pac->nombre2 = $paciente->nombre2;
                $pac->apellido1 = $paciente->apellido1;
                $pac->apellido2 = $paciente->apellido2;
                $pac->direccion = $paciente->direccion;
                $pac->telefono = $paciente->telefono;
                $pac->fecha_nacimiento = $paciente->fecha_nacimiento;
                $pac->save();

            }
            if($model->save())
            {
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
                return $this->redirect(['index']);
            }
        }
        $id_ips = (new Query())->select('idips')->from('usuarios_ips')->where(['idusuario'=>Yii::$app->user->id]);
        // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1;
        $ips = new Ips();
        $ips_list = Ips::find()->where(['idclientes'=>$id_cliente])->all();
        $lista_tipos = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion');
        $lista_tipoid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion');
        $lista_resid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion');
        $lista_pago = ArrayHelper::map(ListasSistema::find()->where('tipo="forma_pago"')->all(),'codigo','descripcion');
        $lista_ciudades = ArrayHelper::map(Ciudades::find()->all(),'id','nombre');
        $lista_eps = ArrayHelper::map(Eps::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');
        $lista_med = ArrayHelper::map($this->getMedRemIps($id_ips),'id','nombre', 'especialidad');
        $lista_medRemGen = ArrayHelper::map($this->getMedRemGen(),'id','nombre', 'especialidad');
        return $this->render('create', [
            'model' => $model, 
            'paciente_model'=>$paciente,
            'ips_model'=>$ips,
            'ips_list'=>$ips_list,
            'lista_tipos'=>$lista_tipos,
            'lista_tipoid'=>$lista_tipoid,
            'lista_resid'=>$lista_resid,
            'lista_ciudades'=>$lista_ciudades,
            'lista_eps'=>$lista_eps,
            'id_cliente'=>$id_cliente,
            'lista_pago'=>$lista_pago,
            'lista_med'=>$lista_med,
            'medicoRemModel'=>$medicoRem,
            'lista_especialidades'=>$lista_especialidades,
            'lista_medRemGen'=>$lista_medRemGen,
        ]);
        
    }

    public function actionGuardarMedico()
    {
        parse_str($_POST['data'],$data);
        $medico = new MedicosRemitentes();
        $medico->codigo = $data['codigo']; 
        $medico->nombre = $data['nombre']; 
        $medico->telefono = $data['telefono']; 
        $medico->email = $data['email']; 
        $medico->especialidades_id = $data['especialidad'];

        if($medico->save()){
            $medicoRem = new MedicosRemitentesIps();
            $medicoRem->medicos_remitentes_id = (new Query())->select('id')->from('medicos_remitentes')->where(['codigo'=>$data['codigo']])->scalar();
            $medicoRem->ips_id = $data['ips'];
            if($medicoRem->save()){
                $r['mensaje'] = 'Nuevo médico guardado';
                $r['id'] = $medicoRem->medicos_remitentes_id;
                $r['nombre'] = $medico->nombre;
                $r['especialidad'] = $medico->especialidades->nombre;
                return json_encode($r);
            }else{
                return 'Hubo un error, por favor intentelo mas tarde';
            }
        }else{
            return 'Hubo un error, por favor intentelo mas tarde';
        }
    }

    public function actionAddMedico() //busca el id, nombre, especialidad de un medico remitente de la lista general para agregarlo al dropdown de medicos remitentes de la ips
    {
        $medico = MedicosRemitentes::findOne($_POST['data']);
        $r['id'] = $_POST['data'];
        $r['nombre'] = $medico->nombre;
        $r['especialidad'] = $medico->especialidades->nombre;

        return json_encode($r);
    }

    public function getMedRemIps($id_ips)
    {
        $query = new Query();
        $query->select('(r.id) AS id, (m.nombre) AS nombre, (e.nombre) AS especialidad')->from('especialidades e')
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

    public function getCampos($id_tipoest)// Obtiene los campos de un estudio con su respectivo titulo
    {
        $sql = new Campos();
        $sql = Campos::find('campos.id, campos.nombre_campo, (titulos.descripcion) AS titulo, campos.titulos_idtitulos, campos.tipo_campo')
        ->joinWith(['titulosIdtitulos' => function($sql){
                    $sql->select('titulos.descripcion');
                }
            ], true, 'LEFT JOIN')->where(['campos.idtipos_servicio'=>$id_tipoest])->orderBy('campos.titulos_idtitulos ASC')->all();
        // $query = new Query();
        // $query->select('c.id, c.nombre_campo, t.descripcion, c.titulos_idtitulos, c.tipo_campo')->from('campos c')
        // ->join('LEFT JOIN','titulos t','t.id = c.titulos_idtitulos')
        // ->where(['c.idtipos_servicio'=>$id_tipoest])->orderBy('c.titulos_idtitulos ASC');

        return $sql;
        // return $query->all();
    }

    public function cliente($id_usuario)
    {
        $query = new Query();
        $query->select('idclientes')->from('usuarios')->where('id=:id_usuario');
        $query->addParams([':id_usuario'=>$id_usuario]);

        return $query->scalar();
    }

    public function actionGetpaciente()
    {
        $query = new Query();
        $query->select('id,nombre1,nombre2,apellido1,apellido2,direccion,telefono,fecha_nacimiento,email,tipo_identificacion')->from('pacientes')->where('identificacion=:identificacion_p');
        $query->addParams([':identificacion_p'=>$_POST['data']]);

        \Yii::$app->response->format = 'json';
        return $query->one();
    }

    public function actionCalcularEdad() //Calcula la edad a partir de la fecha de nacimiento
    {   
        $fecha_nacimiento = $_POST['fecha'];
        if($fecha_nacimiento !== '0000-00-00')
        {
            return date_diff(date_create($fecha_nacimiento), date_create(date('Y-m-d')))->y;
        }else{
            return null;
        }
    }

    public function actionCalcularFecha() {
        if ($_POST['age']) {

            $nuevaFecha = date('Y-m-d', strtotime('-' . $_POST['age'] . ' year'));
            return $nuevaFecha;
        } else {
            return null;
        }
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
        $paciente = new Pacientes();
        $medicoRem = new MedicosRemitentes();

        if ($model->load(Yii::$app->request->post())) {
            $pac = $this->findModelPaciente($model->idpacientes);
            if($paciente->load(Yii::$app->request->post()))
            {
                $pac->identificacion = $paciente->identificacion;
                $pac->tipo_identificacion = $paciente->tipo_identificacion != '' ? $paciente->tipo_identificacion : $pac->tipo_identificacion;
                $pac->nombre1 = $paciente->nombre1;
                $pac->nombre2 = $paciente->nombre2;
                $pac->apellido1 = $paciente->apellido1;
                $pac->apellido2 = $paciente->apellido2;
                $pac->direccion = $paciente->direccion;
                $pac->telefono = $paciente->telefono;
                $pac->fecha_nacimiento = $paciente->fecha_nacimiento;
                $pac->save();

            }
            if(isset($_POST['checkEstado'])){
                if($_POST['checkEstado'] == 'on'){

        //Procesamiento del formulario-----------------------------------------------------------------
                    if(isset($_POST['check_list'])){
                        // return print_r($_POST['check_list']);
                        foreach ($_POST['check_list'] as $value) {

                            $valores_proc = VlrsCamposProcedimientos::find()->where(['idcampos_tipos_servicio'=>$value, 'id_procedimiento'=>$model->id])->one();
                            if($valores_proc == null){
                                $valores_proc = new VlrsCamposProcedimientos();
                            }

                            $valores_proc->id_procedimiento = $model->id;
                            $valores_proc->idcampos_tipos_servicio = $value;
                            $valores_proc->valor = '1';
                            $valores_proc->save();
                        }
                        $model->estado = $model->estado == 'PND' ? 'PRC' : 'FRM';

                    }else{

                        $val_proc = new VlrsCamposProcedimientos();
                        if($val_proc->load(Yii::$app->request->post()) && isset($_POST['VlrsCamposProcedimientos'])){
                            
                            foreach ($val_proc->idcampos_tipos_servicio as $key => $value) {

                                $valores_proc = VlrsCamposProcedimientos::find()->where(['idcampos_tipos_servicio'=>$val_proc->idcampos_tipos_servicio[$key], 'id_procedimiento'=>$model->id])->one();
                                if($valores_proc == null){
                                    $valores_proc = new VlrsCamposProcedimientos();
                                }

                                $valores_proc->id_procedimiento = $model->id;
                                $valores_proc->idcampos_tipos_servicio = $val_proc->idcampos_tipos_servicio[$key];
                                $valores_proc->valor = $_POST['VlrsCamposProcedimientos'][$value]['valor'];
                                $valores_proc->save();
                            }
                             $model->estado = $model->estado == 'PND' ? 'PRC' : 'FRM';
                        }
                    }

                    if($model->estado == 'FRM')
                    {

                        $usuario = Usuarios::findOne(Yii::$app->user->id);
                        $model->idmedico = $usuario->idmedicos;
                        $model->fecha_salida = date('Y-m-d');

                        if($pac->email != null)
                        {
                            $id_ips = (new Query())->select('ips.nombre, ips.id')->distinct()->from('procedimientos p')
                            ->join('INNER JOIN', 'eps', 'eps.id = p.eps_ideps')
                            ->join('INNER JOIN', 'ips', 'ips.id = eps.idips')
                            ->where(['eps.id'=>$model->eps_ideps])->one();
                            // $this->enviarEmail($pac->email,'Resultados de su estudio',$id_ips);
                            // $model->estado = 'EML';
                        }

                    }else{
                        $model->usuario_transcribe = Yii::$app->user->id;
                    }
        //---------------------------------------------------------------------------------------------
                }

            }
            if($model->save()){
                $model->refresh();
                Yii::$app->response->format = 'json';
                return $this->redirect($_POST['url'].'&message=Registro actualizado');
            }
        }
        $id_ips = (new Query())->select('idips')->from('usuarios_ips')->where(['idusuario'=>Yii::$app->user->id]);
        $id_cliente = $this->cliente(Yii::$app->user->id);
        $paciente = new Pacientes();
        $ips = new Ips();
        $plantilla = new PlantillasDiagnosticos();
        $ips_list = Ips::find()->where(['idclientes'=>$id_cliente])->all();
        $lista_estados = ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion');
        $lista_pago = ArrayHelper::map(ListasSistema::find()->where('tipo="forma_pago"')->all(),'codigo','descripcion');
        $lista_tipoid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion');
        $lista_med = ArrayHelper::map($this->getMedRemIps($id_ips),'id','nombre', 'especialidad');
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');
        $lista_med = ArrayHelper::map($this->getMedRemIps($id_ips),'id','nombre', 'especialidad');
        $lista_medRemGen = ArrayHelper::map($this->getMedRemGen(),'id','nombre', 'especialidad');
        $campos = $this->getCampos($model->idtipo_servicio);
        // return print_r($plantilla_titulos);
        return $this->renderAjax('update', [
                    'model' => $model,
                    'paciente_model'=>$paciente,
                    'ips_model'=>$ips,
                    'ips_list'=>$ips_list,
                    'lista_estados'=>$lista_estados,
                    'lista_pago'=>$lista_pago,
                    'lista_med'=>$lista_med,
                    'medicoRemModel'=>$medicoRem,
                    'lista_especialidades'=>$lista_especialidades,
                    'lista_medRemGen'=>$lista_medRemGen,
                    'lista_tipoid'=>$lista_tipoid,
                    'campos'=>$campos,
                    'plantilla'=>$plantilla,
                ]);
  
    }

    public function enviarEmail($email,$asunto,$id_ips)
    {
        $ips = (new Query())->select('mensaje_email,nombre')->from('ips')->where(['id'=>$id_ips])->one();
        Yii::$app->mailer->compose('estudio_firmado',['mensaje'=>$ips['mensaje_email'], 'ips'=>$ips])
            ->setFrom('correo@dominio.com')
            ->setTo($email)
            ->setSubject($asunto)
            // ->setTextBody('Este es el contenido del mensaje')
            ->send();
    }


    public function actionPrint($id) //Imprime los resultados de un estudio
    {   
        $this->layout = 'resultados_layout';
        $model = $this->findModel($id);
        $campos = $this->getCampos($model->idtipo_servicio);
        $model->estado = $model->estado == 'FCT' ? 'IMP' : 'FRM'; //cambia el estado a impreso
        $model->save();

        $content = $this->renderPartial('pdf_resultados', [
                'model' => $model,
                'campos'=>$campos,
            ], true);

        $formato = Pdf::FORMAT_A4;
        $css = '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css';
        $titulo = 'Resultados';
        $this->pdf($formato, $content, $css, $titulo);

       
    }

    public function pdf($formato, $contenido, $css, $titulo)
    {
         $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => $formato,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $contenido,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => $css,
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:16px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Resultados'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>[$titulo], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render(); 
    }

    public function actionGetDescripcion()
    {
        $plantilla = PlantillasDiagnosticos::findOne($_POST['id'])->descripcion;
        return $plantilla;
    }

    public function actionNuevaPlantilla()
    {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['desc'];

        $plantilla = new PlantillasDiagnosticos();
        $plantilla->titulo = $titulo;
        $plantilla->descripcion = $descripcion;
        $plantilla->id_medico = Usuarios::findOne(Yii::$app->user->id)->idmedicos;
        if($plantilla->save())
        {
            return 'Plantilla guardada!';
        }else{
            return 'Error al guardar la plantilla';
        }
         
    }

    public function actionEditarPlantilla()
    {
        $plantilla = PlantillasDiagnosticos::findOne($_POST['id']);
        $plantilla->descripcion = $_POST['desc'];
        if($plantilla->save())
        {
            return 'Se guardaron los cambios correctamente!';
        }else{
            return 'Error: No se guardaron los cambios';
        }
    }

    public function actionPrecio()
    {
        Yii::$app->response->format = 'json';
        $query = (new Query())->select('valor_procedimiento, descuento')->from('tarifas')->where(['idestudios'=>$_POST['cod'], 'eps_id'=>$_POST['id']]);
        return $query->one();
    }

    // public function actionTituloModal()
    // {
    //     Yii::$app->response->format = 'json';
    //     return Procedimientos::find()->select($_POST['campo'])->where(['id'=>$_POST['key']])->one();
    // }

    /**
     * Deletes an existing Procedimientos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    protected function findModelPaciente($id)
    {
        if (($model = Pacientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

     protected function findModelTipos($id)
    {
        if (($model = TiposServicio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    /*Consulta de listados*/
    public function eps($id_ips)
    {
        $query = (new \yii\db\Query());
        $query->select('id,(nombre)AS name')->from('eps')->where('idips=:id');
        $query->addParams([':id'=>$id_ips]);
        $r = $query->all();

        return $r;
    }

    public function tipos_s($id_ips, $id_eps)
    {
        $query = (new \yii\db\Query());
        $query->select('ts.id,(ts.nombre)AS name')->from('tipos_servicio ts')
        ->join('INNER JOIN', 'eps_tipos ep','ep.tipos_servicio_id = ts.id')
        ->join('INNER JOIN', 'eps e','e.id = ep.eps_id')
        ->join('INNER JOIN', 'ips i','i.id = e.idips')
        ->where(['e.id'=>$id_eps]);

        return $query->all();
    }


    public function estudio($id_ips, $id_eps, $id_tipo)
    {
        $query = (new \yii\db\Query());
        $query->select('(es.cod_cups)AS id, (es.descripcion)AS name')->from('estudios es')
        ->join('INNER JOIN', 'estudios_ips ei','ei.cod_cups = es.cod_cups')
        ->join('INNER JOIN', 'tipos_servicio ts','ts.id = ei.idtipo_servicio')
        ->join('INNER JOIN', 'eps_tipos et','et.tipos_servicio_id = ts.id')
        ->join('INNER JOIN', 'eps e','e.id = et.eps_id')
        ->join('INNER JOIN', 'ips i','i.id = e.idips')
        ->where(['i.id'=>$id_ips,'e.id'=>$id_eps, 'ts.id'=>$id_tipo]);

        return $query->all();
    }

     /*-----------------Dependencias---------------------*/
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
}
