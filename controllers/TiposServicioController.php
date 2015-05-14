<?php

namespace app\controllers;

use Yii;
use app\models\TiposServicio;
use app\models\Ips;
use app\models\Clientes;
use app\models\TiposServicioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * TiposServicioController implements the CRUD actions for TiposServicio model.
 */
class TiposServicioController extends Controller
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
     * Lists all TiposServicio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TiposServicioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TiposServicio model.
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
     * Creates a new TiposServicio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TiposServicio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $client_model = new Clientes();
            $clientes = Clientes::find()->all();
            return $this->render('create', [
                'model' => $model, 'clientes' => $clientes, 'client_model' => $client_model,
            ]);
        }
    }

    /**
     * Updates an existing TiposServicio model.
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
            $client_model = new Clientes();
            $clientes = ArrayHelper::map(Clientes::find()->all(), 'id', 'nombre');
            return $this->render('update', [
                'model' => $model,
                'client_model'=>$client_model,
                'list_client'=>$clientes,
            ]);
        }
    }

    /**
     * Deletes an existing TiposServicio model.
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
     * Finds the TiposServicio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TiposServicio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TiposServicio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function cliente($id_cliente)
    {
        $query = (new \yii\db\Query());
        $query->select('id,(nombre)AS name')->from('ips')->where('idclientes=:id');
        $query->addParams([':id'=>$id_cliente]);
        $r = $query->all();

        return $r;
    }


    /*Dependencias*/
    public function actionSubnombre() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $client_id = $parents[0];
                $out = $this->cliente($client_id);
                // $out = Ips::findBySql('select id,(nombre)AS name from ips where idclientes='.$client_id)->all();
                // $out = ArrayHelper::map($nombres, 'id', 'nombre');

                // $out = [['id'=>'1', 'name'=>'prueba 1'],['id'=>'2', 'name'=>'prueba 2']];
                // \Yii::$app->response->format = 'json';
                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }
}
