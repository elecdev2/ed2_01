<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Usuarios;
use app\models\Items;
use app\models\Ips;
use app\models\Especialidades;
use app\models\Medicos;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
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
     * Displays a single Usuarios model.
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
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios();
        $modelMedico = new Medicos();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = sha1($model->password);
            $role = Yii::$app->authManager->getRole($model->perfil);
            if($modelMedico->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $modelMedico])){
                $cod = $modelMedico->codigo;
                $modelMedico->idespecialidades = (new Query())->select('id')->from('especialidades')->where(['codigo'=>$modelMedico->idespecialidades])->scalar();
                $modelMedico->nombre = $model->nombre;
                $modelMedico->save(false);
                $model->idmedicos = (new Query())->select('id')->from('medicos')->where(['codigo'=>$cod])->scalar();
            }
            if($model->save()){
                Yii::$app->authManager->assign($role, $model->id);
                return $this->redirect(['index']);
            }

        }
         // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1;
        $lista_perf = ArrayHelper::map(Items::find()->where(['<>','data','1'])->all(),'name','description');
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find('SELECT (codigo) AS id, (nombre) AS name')->all(),'codigo','nombre');
         return $this->render('create', [
            'model' => $model,
            'id_cliente'=>$id_cliente,
            'lista_perf'=>$lista_perf,
            'modelMedico'=>$modelMedico,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
        ]);
        
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contrasena = $model->password;
        if($model->idmedicos !== null){
            $modelMedico = $this->findModelMedico($model->idmedicos); 
        }else{
            $modelMedico = new Medicos();
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->contrasena !== $contrasena){
                $model->contrasena = sha1($model->contrasena);
            }

            if($modelMedico->load(Yii::$app->request->post())){
                $cod = $modelMedico->codigo;
                $modelMedico->idespecialidades = (new Query())->select('id')->from('especialidades')->where(['codigo'=>$modelMedico->idespecialidades])->scalar();
                $modelMedico->nombre = $model->nombre;
                $modelMedico->save();
                $model->idmedicos = (new Query())->select('id')->from('medicos')->where(['codigo'=>$cod])->scalar();
            }
            
            $role = Yii::$app->authManager->getRole($model->perfil);
            if($model->perfil !== ''){
                Yii::$app->authManager->revokeAll($id);
                Yii::$app->authManager->assign($role, $id);
            } 
            if($model->save()){
                return $this->redirect(['index']);
            }
        }
         // $id_cliente = $this->cliente(Yii::$app->user->id);
        $id_cliente = 1;
        $lista_perf = ArrayHelper::map(Items::find()->where(['<>','data','1'])->all(),'name','description');
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find('SELECT (codigo) AS id, (nombre) AS name')->all(),'codigo','nombre');
        return $this->renderAjax('update', [
            'model' => $model,
            'id_cliente'=>$id_cliente,
            'lista_perf'=>$lista_perf,
            'modelMedico'=>$modelMedico,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
        ]);
        
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $usuario = $this->findModel($id);
        if($usuario->idmedicos !== null){
            $usuario->delete();
            $medico = $this->findModelMedico($usuario->idmedicos)->delete();
        }else{
            $usuario->delete();
        } 

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelMedico($id)
    {
        if (($model = Medicos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
