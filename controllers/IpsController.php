<?php

namespace app\controllers;

use Yii;
use app\models\Ips;
use app\models\ListasSistema;
use app\models\Clientes;
use app\models\IpsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * IpsController implements the CRUD actions for Ips model.
 */
class IpsController extends Controller
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
                        'roles' => ['super_admin'],
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
     * Lists all Ips models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IpsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ips model.
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
     * Creates a new Ips model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ips();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'IPS creada con exito!');
            return $this->redirect(['index']);
        } else {
            $tipo_id = ListasSistema::find()->where('tipo="tipo_identificacion_ips"')->all();
            $clientes = Clientes::find()->all();
            return $this->render('create', [
                'model' => $model, 
                't_id' => $tipo_id, 
                'clientes'=> $clientes,
            ]);
        }
    }

    /**
     * Updates an existing Ips model.
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
            \Yii::$app->getSession()->setFlash('success', 'IPS actualizada con exito!');
                return $this->redirect($_POST['url']);
        } else {
            $tipo_id = ArrayHelper::map(ListasSistema::find()->where(['tipo'=>'tipo_identificacion_ips'])->all(), 'codigo', 'descripcion');
            $list_clientes = ArrayHelper::map(Clientes::find()->all(),'id','nombre');
            $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
            return $this->renderAjax('update', [
                'model' => $model,
                'list_clientes'=>$list_clientes,
                'listdata'=>$tipo_id,
            ]);
        }
    }

    /**
     * Deletes an existing Ips model.
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
     * Finds the Ips model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ips the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ips::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
