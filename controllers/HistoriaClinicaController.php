<?php

namespace app\controllers;

use Yii;
use app\models\HistoriaClinica;
use app\models\HistoriaClinicaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HistoriaClinicaController implements the CRUD actions for HistoriaClinica model.
 */
class HistoriaClinicaController extends Controller
{
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
     * Lists all HistoriaClinica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistoriaClinicaSearch();

        if(count(Yii::$app->request->queryParams) > 0)
        {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }else{
            $dataProvider = null;
        }

        $js = <<<JS
            if($('.search-botonReporte').attr('data-value') != 1){
                $('.fomularioTituloReporte').hide();
            }
            $('.search-botonReporte').on('click', function() {
                $('.fomularioTituloReporte').slideToggle('fast');
                return false;
            });
JS;

        $this->getView()->registerJs($js, yii\web\View::POS_READY, null);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cerrar'=>$dataProvider !== null ? 0 : 1,
        ]);
    }

    /**
     * Displays a single HistoriaClinica model.
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
     * Creates a new HistoriaClinica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HistoriaClinica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HistoriaClinica model.
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
     * Deletes an existing HistoriaClinica model.
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
     * Finds the HistoriaClinica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HistoriaClinica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HistoriaClinica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
