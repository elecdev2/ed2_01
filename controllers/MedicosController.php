<?php

namespace app\controllers;

use Yii;
use app\models\Medicos;
use app\models\Ips;
use app\models\Especialidades;
use app\models\MedicosSearch;
use app\models\Usuarios;
use app\models\ListasSistema;
use app\models\HorarioMedico;

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

    public function actionHorario($id)
    {
        $medico = $this->findModel($id);

        $events = HorarioMedico::find()->where(['medicos_id'=>$id])->asArray()->all();

        if($events != null)
        {

            $i = 0;
            foreach ($events as $key => $value) 
            {
                $horas = explode(',', $events[$key]['horas']); //Coloco los rangos en un array
                foreach ($horas as $keyH => $valueH) {
                    $t[$i]['id'] = $value['id_horario'];
                    $t[$i]['title'] = date('g:i a', strtotime($this->horaRango($horas[$keyH],'start').':00')).'-'.date('g:i a', strtotime($this->horaRango($horas[$keyH],'end').':00'));
                    $t[$i]['start'] = date('c', strtotime($this->fechaEquivalente($value['dia']).'T'.$this->horaRango($horas[$keyH],'start').':00'));
                    $t[$i]['end'] = date('c', strtotime($this->fechaEquivalente($value['dia']).'T'.$this->horaRango($horas[$keyH],'end').':00'));
                    $t[$i]['inicio'] = date('H:i', strtotime($this->horaRango($horas[$keyH],'start').':00'));
                    $t[$i]['fin'] = date('H:i', strtotime($this->horaRango($horas[$keyH],'end').':00'));
                    $i++;
                }
            }
            $events = json_encode($t); //Es el formato en que el calendario funciona
        }else{
            $events = '';
        }


        // return $events;

        return $this->render('horario', [
                'model'=>$medico,
                'events'=>$events,
            ]);
    }

    public function fechaEquivalente($dia)
    {
        switch ($dia) {
            case 0:
                return '2015-07-19';
                break;
            case 1:
                return '2015-07-13';
                break;
            case 2:
                return '2015-07-14';
                break;
            case 3:
                return '2015-07-15';
                break;
            case 4:
                return '2015-07-16';
                break;
            case 5:
                return '2015-07-17';
                break;
            case 6:
                return '2015-07-18';
                break;
        }
    }

    public function horaRango($token,$indicador)
    {
        $horas = explode('-', $token);
        return $indicador == 'start' ? $horas[0] : $horas[1];
    }

    public function actionCrearHoras()
    {
        $dia = substr($_POST['start'], 0, 1);
        $rango_horas = HorarioMedico::find()->where(['medicos_id'=>$_POST['id'], 'dia'=>$dia])->one();

        if($rango_horas != null)
        {
            $rango_horas->horas = $rango_horas->horas.','.substr($_POST['start'], 2, 6).'-'.substr($_POST['end'], 2, 6);
        }else{
            $rango_horas = new HorarioMedico();
            $rango_horas->medicos_id = $_POST['id'];
            $rango_horas->dia = $dia;
            $rango_horas->horas = substr($_POST['start'], 2, 6).'-'.substr($_POST['end'], 2, 6);
        }

        if($rango_horas->save())
        {
            return $rango_horas->id_horario;
        }else{
            return null;
        }
    }

    public function actionDeleteRango($id,$inicio,$fin)
    {

        $rango_horas = HorarioMedico::findOne($id);
        $id_med = $rango_horas->medicos_id;
        $cadena = $inicio.'-'.$fin.',';
        $temp = str_replace($cadena, "", $rango_horas->horas);
        if($temp === $rango_horas->horas)
        {
            $temp = str_replace(','.$inicio.'-'.$fin, "", $rango_horas->horas);
            if($temp === $rango_horas->horas)
            {

                $rango_horas->delete();
                return $id_med;

            }else{$rango_horas->horas = $temp;}
        }else{$rango_horas->horas = $temp;}

        if($rango_horas->save()){
            return $id_med;
        }else{
            return 'No se pudo borrar el rango de horas';
        }
    }

    public function actionConsultarHoras($id)
    {
        $events = HorarioMedico::find()->where(['medicos_id'=>$id])->asArray()->all();

        $i = 0;
        foreach ($events as $key => $value) 
        {
            $horas = explode(',', $events[$key]['horas']); //Coloco los rangos en un array
            foreach ($horas as $keyH => $valueH) {
                $t[$i]['id'] = $value['id_horario'];
                $t[$i]['title'] = date('g:i a', strtotime($this->horaRango($horas[$keyH],'start').':00')).'-'.date('g:i a', strtotime($this->horaRango($horas[$keyH],'end').':00'));
                $t[$i]['start'] = date('c', strtotime($this->fechaEquivalente($value['dia']).'T'.$this->horaRango($horas[$keyH],'start').':00'));
                $t[$i]['end'] = date('c', strtotime($this->fechaEquivalente($value['dia']).'T'.$this->horaRango($horas[$keyH],'end').':00'));
                $t[$i]['inicio'] = date('H:i', strtotime($this->horaRango($horas[$keyH],'start').':00'));
                $t[$i]['fin'] = date('H:i', strtotime($this->horaRango($horas[$keyH],'end').':00'));
                $i++;
            }
        }
        $events = json_encode($t); //Es el formato en que el calendario funciona

        return $events;
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
        $usuario = Usuarios::find()->where(['idmedicos'=>$model->id])->one();
        $nombre = $model->nombre;

        if ($model->load(Yii::$app->request->post())) {

            if($model->nombre !== $nombre){
                $usuario->nombre = $model->nombre;
                // $model->nombre = $nombre;
                $usuario->save();
            }


            if($model->save()){
                if(!empty($model->color))
                {
                    $color = ListasSistema::find()->where(['id'=>$model->color])->one();
                    $color->codigo = $model->id;                
                    $color->save(false);
                }
                return 1;
                // $model->refresh();
                // Yii::$app->response->format = 'json';
                // \Yii::$app->getSession()->setFlash('success', 'Médico actualizado con exito!');
                // return $this->redirect($_POST['url']);
            }else{return 0;}
        } 
        $color = $model->color != null ? 'style=background-color:'.ListasSistema::find()->select(['descripcion'])->where(['id'=>$model->color])->scalar() : '';
        $js = <<<SCRIPT
        $(".field-medicos-color").append("<div class='col-md-3' id='colorBox' $color></div>");
SCRIPT;
        
        $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
        $this->getView()->registerJs('$("#url").val(getUrlVars());', yii\web\View::POS_READY,null);
        return $this->renderAjax('update', [
            'model' => $model,
            'lista_especialidades'=>ArrayHelper::map(Especialidades::find()->all(),'id','nombre'),
            'lista_ips'=>ArrayHelper::map(Ips::find()->all(),'id','nombre'),
            'imagen'=>new UploadFormImages(),
            'lista_colores'=> ArrayHelper::map(ListasSistema::find()->where(['codigo'=>'0', 'tipo'=>'color_med'])->all(), 'id', 'descripcion'),
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

    public function actionConsultarColor()
    {
        return ListasSistema::find()->select(['descripcion'])->where(['id'=>$_POST['id']])->scalar();
    }
}
