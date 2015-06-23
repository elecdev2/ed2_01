<?php

namespace app\controllers;

use Yii;
use app\models\CitasMedicas;
use app\models\CitasMedicasSearch;
use app\models\Medicos;
use app\models\Pacientes;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CitasMedicasController implements the CRUD actions for CitasMedicas model.
 */
class CitasMedicasController extends Controller
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
     * Lists all CitasMedicas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitasMedicasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $events = CitasMedicas::find()->asArray()->all();

        foreach ($events as $key => $value) {
            $t['id'] = $value['id_citas'];
            $t['title'] = 'Cita - '. Medicos::findOne($value['medicos_id'])->nombre;
            $t['start'] = $value['fecha'].'T'.$value['hora'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events'=>'['.json_encode($t).']', //Es el formato en que el calendario funciona
        ]);
    }

    /**
     * Displays a single CitasMedicas model.
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
     * Creates a new CitasMedicas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CitasMedicas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Nueva cita registrada!');
            return $this->redirect(['index']);
        } else {
            $lista_med = ArrayHelper::map(Medicos::find()->all(),'id','nombre');
            $model->fecha = substr($_POST['date'], 0, 10);
            $model->hora = substr($_POST['date'], 11, 8);
            return $this->renderAjax('create', [
                'model' => $model,
                'lista_med'=>$lista_med,
            ]);
        }
    }

    /**
     * Updates an existing CitasMedicas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel($_POST['id']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Cita editada con exito!');
            return $this->redirect(['index']);
        } else {
            $lista_med = ArrayHelper::map(Medicos::find()->all(),'id','nombre');
            $paciente = Pacientes::findOne($model->pacientes_id);
            return $this->renderAjax('update', [
                'model' => $model,
                'lista_med'=>$lista_med,
                'paciente'=>$paciente,
            ]);
        }
    }

    /**
     * Deletes an existing CitasMedicas model.
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
     * Finds the CitasMedicas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CitasMedicas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CitasMedicas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPaciente()
    {
        \Yii::$app->response->format = 'json';
        $paciente = Pacientes::find()->where(['identificacion'=>$_POST['data']])->one();
        return $paciente;
    }
}
