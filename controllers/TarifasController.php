<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Tarifas;
use app\models\Estudios;
use app\models\EpsTipos;
use app\models\Eps;
use app\models\TarifasSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;

/**
 * TarifasController implements the CRUD actions for Tarifas model.
 */
class TarifasController extends Controller
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
                        'roles' => ['tarifas'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view'],
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
     * Lists all Tarifas models.
     * @return mixed
     */
    public function actionIndex($ideps)
    {
        $searchModel = new TarifasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ideps);
        $eps = new Query();
        $eps = $eps->select('nombre')->from('eps')->where(['id'=>$ideps])->scalar();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ideps'=>$ideps,
            'eps'=>$eps,
        ]);
    }

    /**
     * Displays a single Tarifas model.
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
     * Creates a new Tarifas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $ideps = $_POST['ideps'];
        $model = new Tarifas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Tarifa creada con exito!');
            return $this->redirect($_POST['url']);
            // return $this->redirect(['index', 'ideps'=>$ideps]);
        } else {
            
            $lista_estudios = ArrayHelper::map($this->getEstudios($ideps,$model), 'cod_cups', 'descripcion');

            $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
            return $this->renderAjax('create', [
                'model' => $model,
                'ideps'=>$ideps,
                'lista_estudios'=>$lista_estudios,
            ]);
        }
    }

    public function getEstudios($ideps,$model) //Obtiene los estudios para las tarifas
    {
        // $query = new Query();
        $eps = Eps::findOne($ideps);
        // $ips_id = new Query();
        // $idips = $ips_id->select('idips')->from('eps')->where(['id'=>$ideps])->scalar();

        // $estudios = (new Query())->select('idestudios')->from('tarifas')->where(['eps_id'=>$ideps]);
        $estudios = Tarifas::find()->select(['idestudios'])->where(['eps_id'=>$ideps]);
        // if($vista === 'act'){
        //     $estudios->andwhere(['<>','idestudios',$model->idestudios]);
        // }
        $query = Estudios::find()->select(['estudios.cod_cups', 'estudios.descripcion'])->join('INNER JOIN', 'estudios_ips', 'estudios.cod_cups = estudios_ips.cod_cups')
                                ->join('INNER JOIN', 'tipos_servicio', 'estudios_ips.idtipo_servicio = tipos_servicio.id')
                                ->join('INNER JOIN', 'eps_tipos', 'eps_tipos.tipos_servicio_id = tipos_servicio.id')
                                ->join('INNER JOIN', 'eps', 'eps.id = eps_tipos.eps_id')
                                ->where(['eps.idips'=>$eps->idips])->andwhere(['NOT IN', 'estudios.cod_cups', $estudios]);

        // $query->select('(es.cod_cups)AS id,(es.descripcion) AS name')->from('estudios_ips ei')
        //         ->join('INNER JOIN', 'tipos_servicio s', 'ei.idtipo_servicio = s.id')
        //         ->join('INNER JOIN', 'estudios es', 'es.cod_cups = ei.cod_cups')
        //         ->where(['s.idips'=>$eps->idips])
        //         ->andwhere(['NOT IN', 'ei.cod_cups', $estudios]);

        return $query->all();       
    }

    /**
     * Updates an existing Tarifas model.
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
            // \Yii::$app->getSession()->setFlash('success', 'Tarifa actualizada con exito!');
            // return $this->redirect($_POST['url']);
            // return $this->redirect(['index', 'ideps'=>$model->eps_id]);
        }
        // $lista_estudios = ArrayHelper::map($this->getEstudios($model->eps_id,'act',$model), 'id', 'name');

        $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            // 'lista_estudios'=>$lista_estudios,
            'ideps'=>$id,
        ]);
        
    }

    /**
     * Deletes an existing Tarifas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $ideps)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'ideps'=>$ideps]);
    }

    /**
     * Finds the Tarifas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tarifas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tarifas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
