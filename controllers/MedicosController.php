<?php

namespace app\controllers;

use Yii;
use app\models\Medicos;
use app\models\Ips;
use app\models\Especialidades;
use app\models\MedicosSearch;
use app\models\Usuarios;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\UploadFormImages;
use yii\web\UploadedFile;


/**
 * MedicosController implements the CRUD actions for Medicos model.
 */
class MedicosController extends Controller
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
                        'actions' => ['index','update','view'],
                        'roles' => ['medicos'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
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
     * Lists all Medicos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicosSearch();
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'codigo','nombre');
        // if(count(Yii::$app->request->queryParams) > 0){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lista_especialidades'=>$lista_especialidades,
            ]);
        // }else{
        //     return $this->render('index', [
        //         'searchModel' => $searchModel,
        //         'lista_especialidades'=>$lista_especialidades,
        //     ]);
        // }
    }

    /**
     * Displays a single Medicos model.
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
     * Creates a new Medicos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Medicos();
        $model->scenario = 'medico';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Médico creado con exito!');
            return $this->redirect(['index']);
        } else {
            // $id_cliente = $this->cliente(Yii::$app->user->id);
            $id_cliente = 1;
            $lista_especialidades = ArrayHelper::map(Especialidades::find('SELECT id, (nombre) AS name')->all(),'id','nombre');
            $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');
            return $this->render('create', [
                'model' => $model,
                'lista_especialidades'=>$lista_especialidades,
                'lista_ips'=>$lista_ips,
                'id_cliente'=>$id_cliente,
            ]);
        }
    }

    /**
     * Updates an existing Medicos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nombre = $model->nombre;

        if ($model->load(Yii::$app->request->post())) {

            if($model->nombre !== $nombre){
                $usuario = new Usuarios();
                $usuario->nombre = $nombre;
                $model->nombre = $nombre;
                $usuario->save();
            }

            if($model->save()){
                $model->refresh();
                Yii::$app->response->format = 'json';
                \Yii::$app->getSession()->setFlash('success', 'Médico actualizado con exito!');
                return $this->redirect($_POST['url']);
            }
        } 
        $imagen = new UploadFormImages();
        $lista_especialidades = ArrayHelper::map(Especialidades::find()->all(),'id','nombre');
        $lista_ips = ArrayHelper::map(Ips::find()->all(),'id','nombre');

        $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_especialidades'=>$lista_especialidades,
            'lista_ips'=>$lista_ips,
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
            $model = $this->findModel($_POST['medico']);
            if (isset($imagen->file))
            {
                if($model->ruta_firma !== null)
                {
                    unlink('images/firmas/'.$model->ruta_firma);
                }
                $img = md5(time()).'.'. $imagen->file->extension;

                if($imagen->file->extension == 'jpg' || $imagen->file->extension == 'png' || $imagen->file->extension == 'gif')
                {
                    $imagen->file->saveAs('images/firmas/'.$img);
                    $model->ruta_firma = $img;
                    $model->save();
                    \Yii::$app->getSession()->setFlash('success', 'Firma cambiada!');
                }else{
                    \Yii::$app->getSession()->setFlash('error', 'Error: No se pudo cargar su firma, intentelo de nuevo');
                }
                $this->redirect(['index']);
            }
        }
    }

    /**
     * Borra una imagen del servidor.
     * Si la imagen se borra con exito, será redirigido al index.php.
     * @return mixed
     */
    public function actionBorrarFoto($id)
    {
        $model = $this->findModel($id);
        unlink('images/firmas/'.$model->ruta_firma);
        $model->ruta_firma = null;
       
        if($model->save())
        {
            \Yii::$app->getSession()->setFlash('success', 'Firma borrada!');
        }else{
            \Yii::$app->getSession()->setFlash('error', 'Error: No se pudo borrar su firma, intentelo de nuevo');
        }
        $this->redirect(['index']);

    }

    /**
     * Deletes an existing Medicos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Medicos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medicos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medicos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
