<?php

namespace app\controllers;

use Yii;
use app\models\Items;
use app\models\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
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
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Items model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Items();
        $auth = Yii::$app->authManager;
        $lista_perfiles = ArrayHelper::map(Items::find()->where(['data'=>1])->all(), 'name', 'description');

        if (Yii::$app->request->post()) 
        {
            // return print_r($_POST['perf']);
            $model->name = str_replace(' ', '_', $_POST['Items']['description']);
            $role = $auth->createRole($model->name);
            $role->description = $_POST['Items']['description'];
            $role->data = '';

            if($auth->add($role)) {
                foreach ($_POST['perf'] as $value) {
                    $child = $auth->getRole($value);
                    $auth->addChild($role,$child);
                }
                \Yii::$app->getSession()->setFlash('success', 'Perfil creado con exito!');
                return $this->redirect(['index']);
            }

        } 
        return $this->render('create', [
            'model' => $model,
            'lista_perfiles'=>$lista_perfiles,
        ]);
        
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        $lista_perfiles = ArrayHelper::map(Items::find()->where(['data'=>1])->all(), 'name', 'description');

        if (Yii::$app->request->post()) 
        {
            $padre = $auth->getRole($id);
            $auth->removeChildren($padre);
            $model->name = $id; 
            $model->description = $_POST['Items']['description'];

            foreach ($_POST['perf'] as  $value) {
                $child = $auth->getRole($value);
                $auth->addChild($padre,$child);
            }
            
            if($model->save())
            {
                $model->refresh();
                Yii::$app->response->format = 'json';
                \Yii::$app->getSession()->setFlash('success', 'Perfil actualizado con exito!');
                return $this->redirect($_POST['url']);
            }
        } 
        $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_perfiles'=>$lista_perfiles,
        ]);
        
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
