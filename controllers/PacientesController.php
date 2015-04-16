<?php

namespace app\controllers;

use Yii;
use app\models\Pacientes;
use app\models\Ciudades;
use app\models\ListasSistema;
use app\models\Eps;
use app\models\PacientesSearch;
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
                        'actions' => ['index','create','update'],
                        'roles' => ['auxiliar'],
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
        if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lista_tipoid'=>$lista_tipoid,
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'lista_tipoid'=>$lista_tipoid,
            ]);
        }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } 
        // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1; 
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            Yii::$app->response->format = 'json';
            return $this->redirect($_POST['url'].'&message=Registro actualizado');
        }
        // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1; 
        $lista_tipos = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion');
        $lista_tipoid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion');
        $lista_resid = ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion');
        $lista_ciudades = ArrayHelper::map(Ciudades::find()->all(),'id','nombre');
        $lista_eps = ArrayHelper::map(Eps::find()->all(),'id','nombre');
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_tipos'=>$lista_tipos,
            'lista_tipoid'=>$lista_tipoid,
            'lista_resid'=>$lista_resid,
            'lista_ciudades'=>$lista_ciudades,
            'lista_eps'=>$lista_eps,
            'id_cliente'=>$id_cliente,
        ]);
        
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
