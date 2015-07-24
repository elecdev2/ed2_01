<?php

namespace app\controllers;

use Yii;
use app\models\MedicosRemitentes;
use app\models\MedicosRemitentesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\filters\AccessControl;

use app\models\Ips;
use app\models\Especialidades;
use app\models\Usuarios;
use app\models\MedicosRemitentesIps;

/**
 * MedicosRemitentesController implements the CRUD actions for MedicosRemitentes model.
 */
class MedicosRemitentesController extends Controller
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
                        'actions' => ['index','create','update','view','delete'],
                        'roles' => ['medicos'],
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
     * Lists all MedicosRemitentes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicosRemitentesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MedicosRemitentes model.
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
     * Creates a new MedicosRemitentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MedicosRemitentes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $medIps = new MedicosRemitentesIps();
            $medIps->medicos_remitentes_id = $model->id;
            $ips_id->$_POST['ips'];
            $medIps->save();
            \Yii::$app->getSession()->setFlash('success', 'Médico creado con exito!');
            return $this->redirect(['index']);
        } else {
            $ips_model = new Ips();
            $ips_list = Ips::find()->where(['idclientes'=>Usuarios::findOne(Yii::$app->user->id)->idclientes])->all();
            $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(), 'id', 'nombre');
            return $this->render('create', [
                'model' => $model,
                'ips_list'=>$ips_list,
                'ips_model'=>$ips_model,
                'lista_especialidades'=>$lista_especialidades,
            ]);
        }
    }

    /**
     * Updates an existing MedicosRemitentes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            if($model->save())
            {
                return 1;
            }else{
                return 0;
            }
            // $model->refresh();
            // Yii::$app->response->format = 'json';
            // \Yii::$app->getSession()->setFlash('success', 'Médico actualizado con exito!');
            // return $this->redirect($_POST['url']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'ips_list'=>Ips::find()->where(['idclientes'=>Usuarios::findOne(Yii::$app->user->id)->idclientes])->all(),
            'ips_model'=>new Ips(),
            'lista_especialidades'=>ArrayHelper::map(Especialidades::find()->all(), 'id', 'nombre'),
        ]);
        
    }

    /**
     * Deletes an existing MedicosRemitentes model.
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
     * Finds the MedicosRemitentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MedicosRemitentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MedicosRemitentes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
