<?php

namespace app\controllers;

use Yii;
use app\models\Pacientes;
use app\models\Ciudades;
use app\models\ListasSistema;
use app\models\Eps;
use app\models\PacientesSearch;
use app\models\Usuarios;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * PacientesController implements the CRUD actions for Pacientes model.
 */
class PacientesController extends Controller
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
                        'actions' => ['index','create','update','view'],
                        'roles' => ['pacientes'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
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
     * Lists all Pacientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $lista_tipoid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion');
        $searchModel = new PacientesSearch();
        // if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lista_tipoid'=>$lista_tipoid,
            ]);
        // }else{
        //     return $this->render('index', [
        //         'searchModel' => $searchModel,
        //         'lista_tipoid'=>$lista_tipoid,
        //     ]);
        // }
    }

    /**
     * Displays a single Pacientes model.
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
     * Creates a new Pacientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pacientes();
        // $model->scenario = 'paciente';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Paciente nuevo creado con exito!');
            return $this->redirect(['index']);
        } 
        $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
        // $id_cliente = 1; 
        $rango_fecha = $this->rangoFecha();
        $lista_tipos = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion');
        $lista_tipoid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion');
        $lista_resid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion');
        $lista_ciudades = ArrayHelper::map(Ciudades::find()->all(),'id','nombre');
        $lista_eps = ArrayHelper::map(Eps::find()->all(),'id','nombre');
        return $this->render('create', [
            'model' => $model,
            'lista_tipos'=>$lista_tipos,
            'lista_tipoid'=>$lista_tipoid,
            'lista_resid'=>$lista_resid,
            'lista_ciudades'=>$lista_ciudades,
            'lista_eps'=>$lista_eps,
            'id_cliente'=>$id_cliente,
            'rango_fecha'=>$rango_fecha,
        ]);
        
    }

    /**
     * Updates an existing Pacientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $model->scenario = 'paciente';

        if ($model->load(Yii::$app->request->post())) {

            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
            // $model->refresh();
            // Yii::$app->response->format = 'json';
            // \Yii::$app->getSession()->setFlash('success', 'Paciente actualizado con exito!');
            // return $this->redirect($_POST['url']);
        }
        $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
            'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
            'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
            'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
            'lista_eps'=>ArrayHelper::map(Eps::find()->all(),'id','nombre'),
            'id_cliente'=> Usuarios::findOne(Yii::$app->user->id)->idclientes,
            'rango_fecha'=>$this->rangoFecha(),
        ]);
        
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

    /**
     * Deletes an existing Pacientes model.
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
    *Hace la busqueda del titulo de la barra de las ventanas flotantes
    */
    // public function actionTituloModal()
    // {
    //     Yii::$app->response->format = 'json';
    //     return Pacientes::find()->select($_POST['campo'])->where(['id'=>$_POST['key']])->one();
    // }

    /**
     * Finds the Pacientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pacientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pacientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
