<?php

namespace app\controllers;

use Yii;
use app\models\Eps;
use app\models\Ips;
use app\models\Informes;
use app\models\TiposServicio;
use app\models\EpsTipos;
use app\models\EpsSearch;
use app\models\Usuarios;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * EpsController implements the CRUD actions for Eps model.
 */
class EpsController extends Controller
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
                        'actions' => ['index','create','update','view','subtipos'],
                        'roles' => ['eps'],
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
     * Lists all Eps models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EpsSearch();

        // if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        // }else{
        //     return $this->render('index', [
        //         'searchModel' => $searchModel,
        //     ]);
        // }
    }

    /**
     * Displays a single Eps model.
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
     * Creates a new Eps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Eps();

        if ($model->load(Yii::$app->request->post())) {
            $cod_eps = $model->codigo;
            $ips = $model->idips;
            if($model->save(false)){
                $id_eps = $this->getEps($cod_eps,$ips);
                foreach ($_POST['Eps']['tipos_est'] as $key => $value) {
                    $eps_tipos = new EpsTipos();
                    $eps_tipos->eps_id = $id_eps;
                    $eps_tipos->tipos_servicio_id = $value;
                    $eps_tipos->save();
                }
                \Yii::$app->getSession()->setFlash('success', 'EPS creada con exito!');
            }
            return $this->redirect(['index']);
        } 

        $js = <<<js

        $('#url').val(getUrlVars());

        $('#eps-tipos_est').on('change', function(e){
            var val = $('#eps-tipos_est option:selected');
            if(val.attr('value') === '')
                val.remove();
        });
js;

        $this->getView()->registerJs($js, yii\web\View::POS_READY, null);
        $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
        return $this->render('create', [
            'model' => $model,
            'lista_ips'=>ArrayHelper::map(Ips::find()->where(['idclientes'=>$id_cliente])->all(), 'id', 'nombre'),
            'id_cliente'=>$id_cliente,
            'lista_informes'=>ArrayHelper::map(Informes::find()->all(), 'id', 'nombre'),
            'lista_tipos'=>ArrayHelper::map(TiposServicio::find()->all(), 'id', 'nombre'),
        ]);
        
    }

    public function getEps($cod,$ips)
    {
        $query = new Query();
        $query->select('id')->from('eps')->where(['codigo'=>$cod, 'idips'=>$ips]);
        return $query->scalar();
    }

    public function tiposServicio($id_ips)
    {
        $query = new Query();
        $query->select('ts.id, (ts.nombre)AS name')->distinct()->from('eps_tipos ep')->join('INNER JOIN', 'eps e', 'e.id = ep.eps_id')->join('INNER JOIN','ips i','i.id = e.idips')->join('INNER JOIN', 'tipos_servicio ts','ts.id = ep.tipos_servicio_id')
                ->where(['ts.idips'=>$id_ips]);

        return $query->all();       
    }

    public function actionSubtipos()
    {
         $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $ips_id = $parents[0];
                $out = $this->tiposServicio($ips_id);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Updates an existing Eps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->save())
            {
                if(isset($_POST['tipos_estudios'])){
                    EpsTipos::deleteAll(['eps_id'=>$id]);
                    foreach ($_POST['tipos_estudios'] as $key => $value) {
                        $eps_tipos = new EpsTipos();
                        $eps_tipos->eps_id = $id;
                        $eps_tipos->tipos_servicio_id = $value;
                        $eps_tipos->save();
                    }
                }
                return 1;
            }else{
                return 0;
            }
            // $model->refresh();
            // Yii::$app->response->format = 'json';
            // \Yii::$app->getSession()->setFlash('success', 'EPS actualizada con exito!');
            // return $this->redirect($_POST['url']);
        }

        $js = <<<js

        $('#url').val(getUrlVars());

        $('#eps-tipos_est').on('change', function(e){
            var val = $('#eps-tipos_est option:selected');
            if(val.attr('value') === '')
                val.remove();
        });
js;

        $this->getView()->registerJs($js, yii\web\View::POS_READY, null);
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_ips'=>ArrayHelper::map(Ips::find()->all(), 'id', 'nombre'),
            'id_cliente'=>Usuarios::findOne(Yii::$app->user->id)->idclientes,
            'lista_informes'=>ArrayHelper::map(Informes::find()->all(), 'id', 'nombre'),
        ]);
        
    }

    /**
     * Deletes an existing Eps model.
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
     * Finds the Eps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Eps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Eps::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
