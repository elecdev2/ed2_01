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
use yii\web\NotFoundHttpException;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuarios;
use app\models\Items;
use app\models\Ips;
use app\models\Especialidades;
use app\models\Medicos;
use app\models\Pacientes;
use app\models\Procedimientos;
use app\models\Campos;
use app\models\UploadFormImages;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;

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
                        'actions' => ['login','index-resultados','resultados'],
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

    public function actionIndexResultados()
    {
        $this->layout = 'index_layout';
        return $this->render('resultados');
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
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->contrasena !== $contrasena){
                $model->contrasena = sha1($model->contrasena);
            }

            if($model->idmedicos != null){
                $modelMedico->activo = $model->activo == 1 ? 1 : 2;
                $modelMedico->save();
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
        $imagen = new UploadFormImages();
        $usuario =  Usuarios::findOne(Yii::$app->user->id);
        $ips = new Ips();
        $id_cliente = $usuario->idclientes;
        if(Yii::$app->user->can('admin')){
            $lista_perf = ArrayHelper::map(Items::find()->where(['data'=>'0'])->all(),'name','description');
        }else{
            $lista_perf = ArrayHelper::map(Items::find()->where(['data'=>'0'])->andWhere(['<>','name','admin'])->all(),'name','description');
        }
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');
        return $this->render('//usuarios/update', [
            'model' => $model,
            'id_cliente'=>$id_cliente,
            'lista_perf'=>$lista_perf,
            'modelMedico'=>$modelMedico,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
            'imagen'=>$imagen,
            'ipsModel'=>$ips,
        ]);
        
    }

    /**
     * Carga una imagen al servidor.
     * Si la imagen carga con exito, será redirigido al index.php.
     * @return mixed
     */
    public function actionUpload()
    {
        $imagen = new UploadFormImages();

        if(Yii::$app->request->post())
        {
            $imagen->file = UploadedFile::getInstance($imagen, 'file');
            $model = $this->findModel($_POST['usuario']);
            if (isset($imagen->file))
            {
                if($model->foto !== null && $model->foto != 'MDMasAvatar.png' && $model->foto != 'MDFemAvatar.png' && $model->foto != 'SecretariaAvatar.png' && $model->foto != 'UsuarioAvatar.png')
                {
                    unlink('images/fotos_perfiles/'.$model->foto);
                }
                $img = md5(time()).'.'. $imagen->file->extension;

                if($imagen->file->extension == 'jpg' || $imagen->file->extension == 'png' || $imagen->file->extension == 'gif')
                {
                    $imagen->file->saveAs('images/fotos_perfiles/'.$img);
                    $model->foto = $img;
                    $model->save();
                    \Yii::$app->getSession()->setFlash('success', 'Foto de perfil actualizada!');
                }else{
                    \Yii::$app->getSession()->setFlash('error', 'Error: No se pudo cargar su foto, intentelo de nuevo');
                }
                $this->redirect(['update', 'id'=>$model->id]);
            }
        }
    }

    /**
     * Borra la foto del perfil de un usuario y la reemplaza por una por defecto.
     * Si la imagen se borra con exito, será redirigido al index.php.
     * @return mixed
     */
    public function actionBorrarFoto($id)
    {
        $model = $this->findModel($id);
       
        unlink('images/fotos_perfiles/'.$model->foto);
        switch ($model->sexo) {
            case 'M':
                if($model->perfil == 'medico')
                {
                    $model->foto = 'MDMasAvatar.png';
                }else{
                    $model->foto = 'UsuarioAvatar.png';
                }
                break;
            case 'F':
                if($model->perfil == 'medico')
                {
                    $model->foto = 'MDFemAvatar.png';
                }else{
                    $model->foto = 'SecretariaAvatar.png';
                }
                break;
            default:
                # code...
                break;
        }
        
        if($model->save())
        {
            \Yii::$app->getSession()->setFlash('success', 'Foto de perfil borrada!');
        }else{
            \Yii::$app->getSession()->setFlash('error', 'Error: No se pudo borrar su foto, intentelo de nuevo');
        }
        $this->redirect(['update', 'id'=>$model->id]);

    }

    public function actionResultados()
    {
        if(Yii::$app->request->post()){

            $id_paciente = Pacientes::find()->select(['id'])->where(['identificacion'=>$_POST['identificacion']])->scalar();

            $model = $this->findModelProcedimiento($_POST,$id_paciente);

            if($model == null){
                $this->layout = 'index_layout';
                return $this->render('resultados',['m'=>1]);
            }else{
                $campos = $this->getCampos($model->idtipo_servicio);
                $titulo = 'Resultados_'.$model->numero_muestra;
                
                $this->imprimirPDF($titulo,$model,$campos);
            }
        }else{
             $this->layout = 'loginLayout';
             return $this->render('resultados');
        } 

    }

    public function getCampos($id_tipoest)// Obtiene los campos de un estudio con su respectivo titulo
    {
        $sql = new Campos();
        $sql = Campos::find('campos.id, campos.nombre_campo, (titulos.descripcion) AS titulo, campos.titulos_idtitulos, campos.tipo_campo')
        ->joinWith(['titulosIdtitulos' => function($sql){
                    $sql->select('titulos.descripcion');
                }
            ], true, 'LEFT JOIN')->where(['campos.idtipos_servicio'=>$id_tipoest])->orderBy('campos.titulos_idtitulos ASC')->all();

        return $sql;
    }

    public function imprimirPDF($titulo,$model,$campos)
    {
        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;
        $mpdf->WriteHtml($this->renderPartial('pdf_resultados', [
                'model' => $model,
                'campos'=>$campos,
            ], true));
        $mpdf->output($titulo. '.pdf', Pdf::DEST_DOWNLOAD);
    }

     protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelProcedimiento($post, $id_paciente)
    {
        if (($model =  Procedimientos::find()->where(['numero_muestra'=>$post['muestra'], 'idpacientes'=>$id_paciente])->one()) !== null) {
            return $model;
        } else {
            return null;
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
