<?php

namespace app\controllers;

use Yii;
use app\models\Procedimientos;
use app\models\Pacientes;
use app\models\ListasSistema;
use app\models\Ciudades;
use app\models\Eps;
use app\models\Ips;
use app\models\ProcedimientosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\db\Query;

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
        if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lista_estados'=>$lista_estados,
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'lista_estados'=>$lista_estados,
            ]);
        }

    }

    /**
     * Displays a single Procedimientos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
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

        if ($model->load(Yii::$app->request->post())){

            $pac = $this->findModelPaciente($model->idpacientes);
            if($paciente->load(Yii::$app->request->post)){
                $pac->direccion = $paciente->direccion;
                $pac->telefono = $paciente->telefono;
                $pac->fecha_nacimiento = $paciente->fecha_nacimiento;

                if($model->save() && $pac->save()) 
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
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
        ]);
        
    }

    public function cliente($id_usuario)
    {
        $query = (new \yii\db\Query());
        $query->select('idclientes')->from('usuarios')->where('id=:id_usuario');
        $query->addParams([':id_usuario'=>$id_usuario]);

        return $query->scalar();
    }

    public function actionGetpaciente()
    {
        $query = (new \yii\db\Query());
        $query->select('id,nombre1,nombre2,apellido1,apellido2,direccion,telefono,fecha_nacimiento,email')->from('pacientes')->where('identificacion=:identificacion_p');
        $query->addParams([':identificacion_p'=>$_POST['data']]);

        \Yii::$app->response->format = 'json';
        return $query->one();
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
            $model->refresh();
            Yii::$app->response->format = 'json';
            return $this->redirect($_POST['url'].'&message=Registro actualizado');
        }
             // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1;
        $paciente = new Pacientes();
        $ips = new Ips();
        $ips_list = Ips::find()->where(['idclientes'=>$id_cliente])->all();
        $lista_estados = ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion');
        $lista_pago = ArrayHelper::map(ListasSistema::find()->where('tipo="forma_pago"')->all(),'codigo','descripcion');
        return $this->renderAjax('update', [
                    'model' => $model,
                    'paciente_model'=>$paciente,
                    'ips_model'=>$ips,
                    'ips_list'=>$ips_list,
                    'lista_estados'=>$lista_estados,
                    'lista_pago'=>$lista_pago,
                ]);
        
        // else {
        //     // $id_cliente = $this->cliente(Yii::$app->user->id);
        //     $id_cliente = 1;
        //     $paciente = new Pacientes();
        //     $ips = new Ips();
        //     $ips_list = Ips::find()->where(['idclientes'=>$id_cliente])->all();
        //     return $this->render('update', [
        //         'model' => $model,
        //         'paciente_model'=>$paciente,
        //         'ips_model'=>$ips,
        //         'ips_list'=>$ips_list,
        //     ]);
        // }
    }

    public function actionPrecio()
    {
        Yii::$app->response->format = 'json';
        $query = (new Query())->select('valor_procedimiento, descuento')->from('tarifas')->where(['idestudios'=>$_POST['cod'], 'eps_id'=>$_POST['id']]);
        return $query->one();
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModelPaciente($id)
    {
        if (($model = Pacientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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

     /*Dependencias*/
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
