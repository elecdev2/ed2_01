<?php

namespace app\controllers;

use Yii;
use app\models\Campos;
use app\models\Titulos;
use app\models\Clientes;
use app\models\Ips;
use app\models\CamposSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CamposController implements the CRUD actions for Campos model.
 */
class CamposController extends Controller
{
    public $layout = 'panelAdmin';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Campos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CamposSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Campos model.
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
     * Creates a new Campos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Campos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $titulos_model = new Titulos();
            $titulos = Titulos::find()->all();
            $ips_model = new Ips();
            $client_model = new Clientes();
            $clientes = Clientes::find()->all();
            return $this->render('create', [
                'model' => $model, 
                'ips_model' => $ips_model, 
                'client_model'=>$client_model,
                'clientes'=>$clientes,
                'titulos_model'=>$titulos_model,
                'titulos'=>$titulos,
            ]);
        }
    }

    /**
     * Updates an existing Campos model.
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
     * Deletes an existing Campos model.
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
     * Finds the Campos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Campos::findOne($id)) !== null) {
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

    public function ips($id_cliente, $id_ips)
    {
        $query = (new \yii\db\Query());
        $query->select('id, (nombre)AS name')->from('tipos_servicio')->where('idips=(SELECT id FROM ips WHERE id=:id_ips AND idclientes=:id_cliente)');
        $query->addParams([':id_ips'=>$id_ips, ':id_cliente'=>$id_cliente]);
        $r = $query->all();
        // $out = [$r];

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

    public function actionSubtipo() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $client_id = empty($ids[0]) ? null : $ids[0];
            $ips_id = empty($ids[1]) ? null : $ids[1];
            if ($client_id != null) {
               $data = self::ips($client_id, $ips_id);
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
}