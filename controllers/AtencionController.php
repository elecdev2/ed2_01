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
            'lista_estados'=> ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion'),
        ]);
    }

    /**
     * Displays a single Procedimientos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $paciente = new Pacientes();
        $medicoRem = new MedicosRemitentes();

        if ($model->load(Yii::$app->request->post()) && $paciente->load(Yii::$app->request->post()))
        {
            $tipo_serv = TiposServicio::findOne($model->idtipo_servicio);
            $model->usuario_recibe = Yii::$app->user->id;
            $model->numero_muestra = $tipo_serv->serie.$tipo_serv->consecutivo.'-'.date('y');
            $model->cantidad_muestras = 1;


            $pac = Pacientes::findOne($model->idpacientes);

            if($pac == null)
            {
                return 'El paciente no existe';
                $pac = new Pacientes();
                $pac = $paciente->attributes;
                $pac->idclientes = Usuarios::findOne($model->usuario_recibe)->idclientes; 
                $pac->activo = 1;
                $pac->save();
                
            }else{
                $paciente->save();
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
                $hc = new HistoriaClinica();
                $hc->id_paciente = $model->idpacientes;
                $hc->id_tipos = $model->idtipo_servicio;
                $hc->fecha = date('Y-m-d');
                $hc->hora = date('H:i:s');
                $hc->id_medico = $model->idmedico;
                $hc->save();
                return 1;
             
            }else{
                return 0;
            }
        }

        $ips_model = new Ips();
        $model->fecha_atencion = date('Y-m-d');
        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);//subquery
        $lista_meds = (new Query())->select(['id'=>'medicos.id', 'nombre'=>'CONCAT(medicos.nombre, " - " ,especialidades.nombre)'])->from('medicos')
                    ->join('INNER JOIN', 'especialidades', 'medicos.idespecialidades = especialidades.id')->where(['medicos.ips_idips'=>$id_ips])->all();
        $rango_fecha = $this->rangoFecha();
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
            'medicoRemModel'=>$medicoRem,
            'lista_especialidades'=>ArrayHelper::map(Especialidades::find()->all(),'id','nombre'),
            'lista_medRemGen'=>ArrayHelper::map($this->getMedRemGen(),'id','nombre', 'especialidad'),
            'rango_fecha'=>$rango_fecha,
            'lista_meds'=> ArrayHelper::map($lista_meds, 'id', 'nombre'),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    
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
        $fecha_min = strtotime('-85 year', strtotime($fecha));
        $fecha_max = strtotime('-0 year', strtotime($fecha));
        $fecha_min = date('Y', $fecha_min);
        $fecha_max = date('Y', $fecha_max);

        return $fecha_min.':'.$fecha_max;
    }

    /*Consulta de listados*/
    public function eps($id_ips)
    {
        $query = (new \yii\db\Query());
        $query->select(['id'=>'id', 'name'=>'nombre'])->from('eps')->where(['idips'=>$id_ips]);
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
