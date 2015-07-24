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
use app\models\UsuariosIps;
use app\models\UploadFormImages;
use yii\web\UploadedFile;

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
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','view','delete'],
                        'roles' => ['usuarios'],
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

            if(($model->perfil == 'medico') && (isset($model->ips_medico) && isset($model->codigo_medico) && isset($model->especialidad)))
            {
                $modelMedico->codigo = $model->codigo_medico;
                $modelMedico->ips_idips = $model->ips_medico;
                $modelMedico->idespecialidades = $model->especialidad;
                $modelMedico->nombre = $model->sexo == 'F' ? 'Dra. '.$model->nombre : 'Dr. '.$model->nombre;
                $modelMedico->activo = $model->activo;
                $modelMedico->idclientes = $model->idclientes;
                
                if($modelMedico->save()){
                    $model->idmedicos = $modelMedico->id;
                }
            }

            if($model->save()){
                Yii::$app->authManager->assign($role, $model->id);
                if($model->perfil !== 'medico')
                {
                    $ipss = $_POST['Ips']['id'];
                    foreach ($_POST['Ips']['id'] as $key) {
                        $usuario_ips = new UsuariosIps();
                        $usuario_ips->idusuario = $model->id;
                        $usuario_ips->idips = $key;
                    }
                }else{
                        $usuario_ips = new UsuariosIps();
                        $usuario_ips->idusuario = $model->id;
                        $usuario_ips->idips = $model->ips_medico;
                }
                $usuario_ips->save();
                \Yii::$app->getSession()->setFlash('success', 'Usuario creado con exito!');
                return $this->redirect(['index']);
            }

        }
         // $lista_clientes = ArrayHelper::map((new Query)->select(['id'=>'cl.id','nombre'=>'cl.nombre'])->from('usuarios_ips')
         // ->join('INNER JOIN', 'usuarios u', 'usuarios_ips.id = u.id')
         // ->join('INNER JOIN', 'clientes cl', 'u.idclientes = cl.id')
         // ->where(['usuarios_ips.id'=>Yii::$app->user->id])->all(), 'id', 'nombre');

        $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
        $ips = new Ips();
        if(Yii::$app->user->can('admin')){
            $lista_perf = ArrayHelper::map(Items::find()->where(['data'=>'0'])->all(),'name','description');
        }else{
             $lista_perf = ArrayHelper::map(Items::find()->where(['data'=>'0'])->andWhere(['<>','name','admin'])->all(),'name','description');
        }
        $lista_ips = ArrayHelper::map(Ips::find()->where(['idclientes'=>$id_cliente])->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');
         return $this->render('create', [
            'model' => $model,
            // 'lista_clientes'=>$lista_clientes,
            'lista_perf'=>$lista_perf,
            'modelMedico'=>$modelMedico,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
            'id_cliente'=>$id_cliente,
            'ipsModel'=>$ips,
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
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->password !== $contrasena){
                $model->password = sha1($model->password);
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
                return 1;
                // \Yii::$app->getSession()->setFlash('success', 'Usuario actualizado con exito!');
                // return $this->redirect($_POST['url']);
            }else{
                return 0;
            }
        }

        $imagen = new UploadFormImages();
        $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
        $ips = new Ips();
        if(Yii::$app->user->can('admin')){
            $lista_perf = ArrayHelper::map(Items::find()->where(['<>', 'data', '1'])->andWhere(['<>','name','super_admin'])->all(),'name','description');
        }else{
             $lista_perf = ArrayHelper::map(Items::find()->where(['<>', 'data', '1'])->andWhere(['<>','name','admin'])->all(),'name','description');
        }
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');

        $ips->id = $model->perfil != 'medico' ? $this->ipsSeleccionadas($model) : '';

        $this->getView()->registerJs('$("#url").val(getUrlVars());$("#panelMedico").hide();', yii\web\View::POS_READY,null);
        // return print_r($lista_ips_select);
        return $this->renderAjax('update', [
            'model' => $model,
            'id_cliente'=>$id_cliente,
            'lista_perf'=>$lista_perf,
            'lista_ips'=>$lista_ips,
            'lista_especialidades'=>$lista_especialidades,
            'ipsModel'=>$ips,
            'imagen'=>$imagen,
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
                $this->redirect(['index']);
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
        $this->redirect(['index']);

    }

    public function ipsSeleccionadas($model)
    {
        $ips_select = (new Query)->select('idips')->from('usuarios_ips')->where(['idusuario'=>$model->id])->all();
        $i = 0;
        foreach ($ips_select as $key => $value) {
            $temp[$i] = $ips_select[$i]['idips'];
            $i++;
        }

        return $temp;
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
            $usuario->activo = 2;
            $medico = $this->findModelMedico($usuario->idmedicos);
            $medico->activo = 2;
            $medico->save();
        }else{
            $usuario->activo = 2;
        } 
        if($usuario->save()){
            return $this->redirect(['index']);
        }
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
