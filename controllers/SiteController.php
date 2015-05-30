<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Query;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuarios;
use app\models\Items;
use app\models\Ips;
use app\models\Especialidades;
use app\models\Medicos;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        // 'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'index_layout';
        return $this->render('index');
    }

    public function actionAdmin()
    {
        return $this->render('panelAdmin');
    }

    public function actionLogin()
    {
        $this->layout = 'loginLayout';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

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
        $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
        $lista_perf = ArrayHelper::map(Items::find()->where(['<>','data','1'])->all(),'name','description');
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find('SELECT (codigo) AS id, (nombre) AS name')->all(),'codigo','nombre');
        return $this->render('//usuarios/update', [
            'model' => $model,
            'id_cliente'=>$id_cliente,
            'lista_perf'=>$lista_perf,
            'modelMedico'=>$modelMedico,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
        ]);
        
    }

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
