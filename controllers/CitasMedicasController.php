<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\CitasMedicas;
use app\models\CitasMedicasSearch;
use app\models\Medicos;
use app\models\Pacientes;
use app\models\Especialidades;
use app\models\Usuarios;
use app\models\ListasSistema;
use app\models\Ciudades;
use app\models\Eps;
use app\models\Ips;
use app\models\UsuariosIps;
use app\models\HorarioMedico;
use app\models\HistoriaClinica;
use app\models\MotivoEnfermedad;
use app\models\AntecedentesPatologicos;
use app\models\AntecedentesFamiliares;
use app\models\Habitos;
use app\models\RevSistemas;
use app\models\ExamenFisico;
use app\models\ExploracionRegional;
use app\models\AnalisisDiag;
use app\models\AnalisisImpresiondiagnostica;
use app\models\CodCie10;
use app\models\TiposServicio;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\db\Query;

/**
 * CitasMedicasController implements the CRUD actions for CitasMedicas model.
 */
class CitasMedicasController extends Controller
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
                        'actions'=>['index','medico','view','create','update','calendar','calendario','index-ipss','index-ips','submed','submed2','paciente','cancel'],
                        'roles' => ['agenda'],
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

    public function actionReporte()
    {
        $searchModel = new CitasMedicasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('reporte', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function rand_color($num) {
    //     return '#' . str_pad(dechex($num), 6, '0', STR_PAD_LEFT);
    // }

    public function actionConfig()
    {
        $model = new Ips();
        $ipss = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);
        return $this->render('config', [
            'model' => $model,
            'ips_list'=>ArrayHelper::map(Ips::find()->where(['id'=>$ipss])->all(),'id','nombre'),
        ]);
    }

    public function actionConsultaHoras()
    {
        \Yii::$app->response->format = 'json';
        $ips = Ips::findOne($_POST['id']);
        return $ips;
    }

    public function actionConfigCita()
    {

        if(Yii::$app->request->post())
        {
            $ips = Ips::findOne($_POST['Ips']['id']);
            $ips->tiempo_citas = date('H:i:s', strtotime($_POST['Ips']['tiempo_citas']));
            $ips->hora_inicio = date('H:i:s', strtotime($_POST['Ips']['hora_inicio']));
            $ips->hora_fin = date('H:i:s', strtotime($_POST['Ips']['hora_fin']));

            // return print_r($ips);


            if($ips->save(false))
            {
                \Yii::$app->getSession()->setFlash('success', 'Se guardaron los cambios correctamente!');
            }else{
                \Yii::$app->getSession()->setFlash('error', 'No se pudieron guardar los cambios, por favor revise los datos antes de guardar');
            }
            return $this->redirect(['config']);
        }

        return $this->redirect(['config']);
    }

    /**
     * Lists all CitasMedicas models.
     * @return mixed
     */
    public function actionIndex()
    {

        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);
        $num_ipss = $id_ips->count();
        

        if($num_ipss > 1)
        {
            $this->redirect(['index-ipss']);
        }else{
            $this->redirect('index-ips');
        }

    }

    public function actionIndexIps()
    {
        $searchModel = new CitasMedicasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id])->scalar();
        $ipss = Ips::findOne($id_ips);

        $events = '';
        $lista_esp = Especialidades::find()->join('INNER JOIN', 'medicos m', 'idespecialidades = especialidades.id')->join('INNER JOIN', 'ips i', 'i.id = m.ips_idips')->where(['i.id'=>$ipss->id])->all();
        
        $meds = Medicos::find()->select(['id'])->where(['ips_idips'=>$ipss->id]);
        $events = CitasMedicas::find()->where(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->andWhere(['medicos_id'=>$meds])->asArray()->all();

        $i = 0;
        foreach ($events as $key => $value) {
            $medico = Medicos::findOne($value['medicos_id']);
            $t[$i]['id'] = $value['id_citas'];
            $t[$i]['title'] = $medico->nombre;
            $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
            $t[$i]['color'] = strtotime($value['fecha']) < strtotime(date('Y-m-d')) ? '#C1CAD1' : ListasSistema::find()->select(['descripcion'])->where(['id'=>$medico->color])->scalar();
            $t[$i]['medico'] = $medico->id;
            $i++;
        }
        $events = json_encode($t); //Es el formato en que el calendario funciona

        $this->getView()->registerJs('$("#citasmedicassearch-ips").val('.$ipss->id.')', yii\web\View::POS_READY,null);
        $this->getView()->registerJs('$("#txtIdIps").attr("value", '.$ipss->id.');', yii\web\View::POS_READY,null);
        
        $js = <<<JS
            $("#esp").prepend("<option value=9999>Mostrar todos los médicos</option>");
            $("#esp").prepend("<option value=0>Mostrar todas las citas</option>");
       
JS;
        $this->getView()->registerJs($js, yii\web\View::POS_READY,null);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'lista_esp'=>ArrayHelper::map($lista_esp, 'id', 'nombre'),
            'events'=>$events,
            'calendar'=>1,
            'num_ipss'=>false,
            'modelIps'=>$ipss,
            'dias'=> [],
        ]);
        
       
    }

    public function actionIndexIpss()
    {
        $searchModel = new CitasMedicasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);
        $ipss = Ips::find()->where(['id'=>$id_ips])->all();
        $modelIps = new Ips();

        $events = '';
        $calendar = 0;
        $lista_esp = Especialidades::find();

        if(Yii::$app->request->post())
        {
            $meds = Medicos::find()->select(['id'])->where(['ips_idips'=>$_POST['CitasMedicasSearch']['ips']]);
            $events = CitasMedicas::find()->where(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->andWhere(['medicos_id'=>$meds])->asArray()->all();

            $modelIps = Ips::findOne($_POST['CitasMedicasSearch']['ips']);
            $i = 0;
            foreach ($events as $key => $value) {
                $medico = Medicos::findOne($value['medicos_id']);
                $t[$i]['id'] = $value['id_citas'];
                $t[$i]['title'] = $medico->nombre;
                $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
                $t[$i]['color'] = (strtotime($value['fecha']) < strtotime(date('Y-m-d'))) ? '#C1CAD1' : ListasSistema::find()->select(['descripcion'])->where(['id'=>$medico->color])->scalar();
                $t[$i]['medico'] = $medico->id;
                $i++;
            }
            if($events != null)
            {
                $events = json_encode($t); //Es el formato en que el calendario funciona
            }else{
                $events = '';
            }
            $calendar = 1;

            $this->getView()->registerJs('$("#citasmedicassearch-ips").val('.$_POST['CitasMedicasSearch']['ips'].')', yii\web\View::POS_READY,null);
            $this->getView()->registerJs('$("#txtIdIps").attr("value", '.$_POST['CitasMedicasSearch']['ips'].');', yii\web\View::POS_READY,null);
            $lista_esp = Especialidades::find()->join('INNER JOIN', 'medicos m', 'idespecialidades = especialidades.id')->join('INNER JOIN', 'ips i', 'i.id = m.ips_idips')->where(['i.id'=>$_POST['CitasMedicasSearch']['ips']])->all();
            $js = <<<JS
                $("#esp").prepend("<option value=9999>Mostrar todos los médicos</option>");
                $("#esp").prepend("<option value=0>Mostrar todas las citas</option>");
       
JS;
            $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
        }                


        return $this->render('index', [
            'searchModel' => $searchModel,
            'lista_esp'=>ArrayHelper::map($lista_esp, 'id', 'nombre'),
            'events'=>$events,
            'calendar'=>$calendar,
            'num_ipss'=>true,
            'ipss'=>ArrayHelper::map($ipss, 'id', 'nombre'),
            'modelIps'=>$modelIps,
            'dias'=> [],
        ]);
        
       
    }

    public function codEvents($events)
    {
         $i = 0;
        foreach ($events as $key => $value) {
            $medico = Medicos::findOne($value['medicos_id']);
            $cita = $this->findModel($value['id_citas']);
            if(strtotime($value['fecha']) < strtotime(date('Y-m-d')) && $cita->estado !== 'AUS')
            {
                $cita->estado = 'CLS';
                $cita->save();
            }
            if(strtotime($value['fecha']) == strtotime(date('Y-m-d')) && (strtotime($cita->hora) < strtotime(date('H:i:s'))) && $cita->estado == 'NOR')
            {
                $cita->estado = 'AUS';
                $cita->save();
            }
            $paciente = Pacientes::find()->where(['id'=>$cita->pacientes_id])->one();
            $t[$i]['id'] = $value['id_citas'];
            $t[$i]['title'] = $paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2;
            $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
            $t[$i]['color'] = substr(ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$cita->estado])->scalar(), 0, 7);
            $t[$i]['medico'] = $medico->id;
            $i++;
        }
        $events = $events != null ? json_encode($t) : ''; //Es el formato en que el calendario funciona

        return $events;
    }

    public function codEventsMultiple($events)
    {
        $i = 0;
        foreach ($events as $key => $value) {
            $medico = Medicos::findOne($value['medicos_id']);
            $t[$i]['id'] = $value['id_citas'];
            $t[$i]['title'] = $medico->nombre;
            $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
            $t[$i]['color'] = (strtotime($value['fecha']) < strtotime(date('Y-m-d'))) ? '#C1CAD1' : ListasSistema::find()->select(['descripcion'])->where(['id'=>$medico->color])->scalar();
            $t[$i]['medico'] = $medico->id;
            $i++;
        }
        $events = $events != null ? json_encode($t) : ''; //Es el formato en que el calendario funciona

        return $events;
    }

    public function actionCalendar()
    {
        if(isset($_POST['CitasMedicasSearch']['idespecialidades']) && (isset($_POST['CitasMedicasSearch']['medicos_id']) && $_POST['CitasMedicasSearch']['medicos_id'] == 0))
        {
            if($_POST['CitasMedicasSearch']['idespecialidades'] == 0 || $_POST['CitasMedicasSearch']['idespecialidades'] == 9999)
            {
                $med = 0;
                $not_dias = [];
            }else{
                $especialidad = Especialidades::findOne($_POST['CitasMedicasSearch']['idespecialidades']);
                $med = Medicos::find()->select(['id'])->where(['idespecialidades'=>$especialidad->id, 'activo'=>1, 'ips_idips'=>$_POST['ips']]);
                $this->getView()->registerJs('$("h2#nombre_med").html("'.$especialidad->nombre.'");', yii\web\View::POS_READY,null);
                $not_dias = [];
            }
        }else{
            if(isset($_POST['CitasMedicasSearch']['medicos_id']))
            {
                $med = $_POST['CitasMedicasSearch']['medicos_id'];
                $this->getView()->registerJs('$("h2#nombre_med").html("'.Medicos::findOne($med)->nombre.'");', yii\web\View::POS_READY,null);
                $this->getView()->registerJs('$("h2#nombre_med").attr("data-value", '.$med.');', yii\web\View::POS_READY,null);
                $not_dias = [0,1,2,3,4,5,6];
            }else{
                $med = 0;
                $not_dias = [];
            }
        }
        
        $js = <<<JS
        $("#esp").prepend("<option value=9999>Mostrar todos los médicos</option>");
        $("#esp").prepend("<option value=0>Mostrar todas las citas</option>");
       
JS;
        $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
        $this->getView()->registerJs('$("#citasmedicassearch-ips").val('.$_POST['ips'].')', yii\web\View::POS_READY,null);
        $this->getView()->registerJs('$("#txtIdIps").attr("value", '.$_POST['ips'].');', yii\web\View::POS_READY,null);

        return $this->actionCalendario($med, $_POST['num_ips'], $_POST['ips'], $not_dias);
    }

    public function actionCalendario($med, $num_ips, $ips, $not_dias)
    {
        $searchModel = new CitasMedicasSearch();
        $id_ips = UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]);
        $ipss = Ips::find()->where(['id'=>$id_ips])->all();
        $modelIps = new Ips();

        $events = null;
        if(Yii::$app->request->post()){
            $modelIps = Ips::findOne($ips);
            if($med != null)
            {
                $events = CitasMedicas::find()->where(['medicos_id'=>$med])->andWhere(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->asArray()->all();
                $dias = HorarioMedico::find()->select(['dia'])->where(['medicos_id'=>$med])->asArray()->all();
                // $not_dias = [0,1,2,3,4,5,6];
                foreach ($dias as $key => $value) {
                    unset($not_dias[$value['dia']]);
                }

                $events = is_object($med) ?  $this->codEventsMultiple($events) :  $this->codEvents($events);
               
            }elseif($med == 0){

                if($num_ips)
                {
                    $meds = Medicos::find()->select(['id'])->where(['ips_idips'=>$ips]);
                    $events = CitasMedicas::find()->where(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->andWhere(['medicos_id'=>$meds])->asArray()->all();
                   
                    $events = $this->codEventsMultiple($events);
                }else{
                    $this->redirect(['index-ips']);                  
                }
                $not_dias = [];
            }
            $lista_esp = Especialidades::find()->join('INNER JOIN', 'medicos m', 'idespecialidades = especialidades.id')->join('INNER JOIN', 'ips i', 'i.id = m.ips_idips')->where(['i.id'=>$ips])->all();
        }

        return $this->render('index', [
            'searchModel'=>$searchModel,
            'lista_esp'=>ArrayHelper::map($lista_esp, 'id', 'nombre'),
            'events'=>$events,
            'num_ipss'=>$num_ips,
            'ipss'=>ArrayHelper::map($ipss, 'id', 'nombre'),
            'calendar'=>1,
            'modelIps'=>$modelIps,
            'dias'=>$not_dias,
        ]);
    }

    public function actionMedico()
    {
        $medico = Usuarios::findOne(Yii::$app->user->id)->idmedicos;
        $events = CitasMedicas::find()->where(['medicos_id'=>$medico])->andWhere(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->asArray()->all();
        
        $i = 0;
        foreach ($events as $key => $value) {
            $cita = $this->findModel($value['id_citas']);
            $paciente = Pacientes::find()->where(['id'=>$cita->pacientes_id])->one();
            $t[$i]['id'] = $value['id_citas'];
            $t[$i]['title'] = $paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2;
            $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
            $t[$i]['color'] = substr(ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$cita->estado])->scalar(), 0, 7);
            $i++;
        }
        $events = $events != null ? json_encode($t) : ''; //Es el formato en que el calendario funciona
      

        return $this->render('medico', [
            'id_medico'=>$medico,
            'events'=>$events,
        ]);
    }


    /**
     * Displays a single CitasMedicas model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewCita($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('view_cita', [
            'model' => $model,
            'paciente'=>Pacientes::findOne($model->pacientes_id),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('view', [
            'model' => $model,
            'paciente'=>Pacientes::findOne($model->pacientes_id),
        ]);
    }

    /**
     * Creates a new CitasMedicas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date, $ips, $dia, $med)
    {
        $model = new CitasMedicas();
        $paciente = new Pacientes();

        if ($model->load(Yii::$app->request->post())) 
        {
            if($this->validarHoras($model->medicos_id, date('w', strtotime($model->fecha)), substr($model->hora, 0, 5)))
            {
                $paciente = Pacientes::find()->where(['identificacion'=>$_POST['documento_cita']])->one();
                $model->estado = 'NOR';
                if($paciente != null)
                {
                    $paciente->load(Yii::$app->request->post());
                }else{
                    $paciente = new Pacientes();
                    $paciente->identificacion = $_POST['documento_cita'];
                    $paciente->load(Yii::$app->request->post());
                }
                if($paciente->save())
                {
                    $model->pacientes_id = $paciente->id;
                }
                if($model->save())
                {
                    $pac = Pacientes::findOne($model->pacientes_id);
                    $medico = Medicos::findOne($model->medicos_id);

                    $e['id'] = $model->id_citas;
                    $e['start'] = $date;
                    $e['title'] = $med !== '' ? $pac->nombre1.' '.$pac->nombre2.' '.$pac->apellido1.' '.$pac->apellido2 : $medico->nombre;
                    $e['color'] = $med !== '' ? substr(ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$model->estado])->scalar(), 0, 7) : ListasSistema::find()->select(['descripcion'])->where(['id'=>$medico->color])->scalar();
                    \Yii::$app->response->format = 'json';
                    return $e;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }
        if($med !== '')
        {
            $temp = $this->validarHoras($med, $dia, substr($date, 11, 8));
            if(!$temp){
                return 0;
            }
        }

        $model->fecha = substr($date, 0, 10);
        $model->hora = substr($date, 11, 8);
        if(strtotime($model->fecha) < strtotime(date('Y-m-d')))
        {
            return 1;
        }elseif ((strtotime($model->fecha) == strtotime(date('Y-m-d'))) && (strtotime($model->hora) < strtotime(date('H:i:s')))) {
            return 2;
        }

        if(CitasMedicas::find()->where(['fecha'=>$model->fecha, 'hora'=>$model->hora])->andWhere(['<>','estado','REP'])->exists()){
            return 3;
        }
        return $this->renderAjax('create', [
            'model' => $model,
            'paciente'=> $paciente,
            'rango_fecha'=>$this->rangoFecha(),
            'lista_med'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>$ips])->all(),'id','nombre'),
            'id_cliente'=>Usuarios::findOne(Yii::$app->user->id)->idclientes,
            'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
            'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
            'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
            'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
            'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$ips])->all(),'id','nombre'),
            'motivo'=>ArrayHelper::map(TiposServicio::find()->where(['idips'=>$ips])->all(),'id','nombre'),
        ]);
    }

//     /**
//      * Creates a new CitasMedicas model.
//      * If creation is successful, the browser will be redirected to the 'view' page.
//      * @return mixed
//      */
//     public function actionCrear($date, $ips, $num_ips, $dia, $med)
//     {
//         $model = new CitasMedicas();
//         $paciente = new Pacientes();


//         if ($model->load(Yii::$app->request->post())) {

//             if($this->validarHoras($model->medicos_id, date('w', strtotime($model->fecha)), substr($model->hora, 0, 5)))
//             {
//                 // $paciente = Pacientes::findOne($model->pacientes_id);
//                 $paciente = Pacientes::find()->where(['identificacion'=>$_POST['documento_cita']])->one();
//                 $model->estado = 'NOR';
//                 if($paciente != null)
//                 {
//                     $paciente->load(Yii::$app->request->post());
//                 }else{
//                     $paciente = new Pacientes();
//                     $paciente->identificacion = $_POST['documento_cita'];
//                     $paciente->load(Yii::$app->request->post());
//                 }
//                 if($paciente->save())
//                 {
//                     $model->pacientes_id = $paciente->id;
//                 }
//                 if($model->save())
//                 {
//                     // \Yii::$app->getSession()->setFlash('success', 'Nueva cita agendada!');
//                 }else{
//                     // \Yii::$app->getSession()->setFlash('error', 'Error: No se puede agendar la cita');
//                 }
//                 $this->getView()->registerJs('$("h2#nombre_med").attr("data-value", '.$model->medicos_id.');', yii\web\View::POS_READY,null);
//             }else{
//                 \Yii::$app->getSession()->setFlash('error', 'Error: Hora no disponible!');
//             }

//             $js = <<<JS
//             $("#esp").prepend("<option value=9999>Mostrar todos los médicos</option>");
//             $("#esp").prepend("<option value=0>Mostrar todas las citas</option>");
   
// JS;
//             $js2 = '$("h2#nombre_med").html("'.Medicos::findOne($model->medicos_id)->nombre.'");';
//             $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
//             $this->getView()->registerJs($js2, yii\web\View::POS_READY,null);
//             $this->getView()->registerJs('$("#citasmedicassearch-ips").val('.$ips.')', yii\web\View::POS_READY,null);
//             $this->getView()->registerJs('$("#txtIdIps").attr("value", '.$ips.');', yii\web\View::POS_READY,null);
            
//             return $this->actionCalendario($model->medicos_id, $num_ips, $ips, [0,1,2,3,4,5,6]);

//         } else {

//             if($med !== '')
//             {
//                 $temp = $this->validarHoras($med, $dia, substr($date, 11, 8));
//                 if(!$temp){
//                     return 0;
//                 }
//             }

//             $model->fecha = substr($date, 0, 10);
//             $model->hora = substr($date, 11, 8);
//             if(strtotime($model->fecha) < strtotime(date('Y-m-d')))
//             {
//                 return 0;
//             }elseif ((strtotime($model->fecha) == strtotime(date('Y-m-d'))) && (strtotime($model->hora) < strtotime(date('H:i:s')))) {
//                 return 0;
//             }

//             if(CitasMedicas::find()->where(['fecha'=>$model->fecha, 'hora'=>$model->hora])->exists()){
//                 return 0;
//             }
//             return $this->renderAjax('create', [
//                 'model' => $model,
//                 'paciente'=> new Pacientes(),
//                 'rango_fecha'=>$this->rangoFecha(),
//                 'lista_med'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>$ips])->all(),'id','nombre'),
//                 'id_cliente'=>Usuarios::findOne(Yii::$app->user->id)->idclientes,
//                 'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
//                 'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
//                 'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
//                 'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
//                 'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$ips])->all(),'id','nombre'),
//             ]);
//         }
//     }

//     /**
//      * Updates an existing CitasMedicas model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionUpdate($id, $ips, $num_ips)
//     {
//         $model = $this->findModel($id);
//         $fecha_cita = $model->fecha;
//         $paciente = Pacientes::findOne($model->pacientes_id);

//         if ($model->load(Yii::$app->request->post())) 
//         {
//             $paciente->load(Yii::$app->request->post());
//             if($model->hora_llegada != null)
//             {
//                 $model->estado = 'PRE';
//             }
//             if(strtotime($model->fecha) < strtotime(date('Y-m-d')))
//             {
//                 return 2;
//             }
//             if((strtotime($model->fecha) == strtotime(date('Y-m-d'))) && (strtotime($model->hora) < strtotime(date('H:i:s'))))
//             {
//                 return 3;
//             }
//             if($model->save() && $paciente->save())
//             {
//                 return 0;
//             }else{
//                 return 1;
//             }

//             $js = <<<JS
//             $("#esp").prepend("<option value=9999>Mostrar todos los médicos</option>");
//             $("#esp").prepend("<option value=0>Mostrar todas las citas</option>");

   
// JS;
//             $js2 = '$("h2#nombre_med").html("'.Medicos::findOne($model->medicos_id)->nombre.'");';
//             $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
//             $this->getView()->registerJs($js2, yii\web\View::POS_READY,null);
//             $this->getView()->registerJs('$("#citasmedicassearch-ips").val('.$ips.')', yii\web\View::POS_READY,null);
//             $this->getView()->registerJs('$("#txtIdIps").attr("value", '.$ips.');', yii\web\View::POS_READY,null);

            
//             return $this->actionCalendario($_POST['url'], $num_ips, $ips, [0,1,2,3,4,5,6]);
            
//         } else {
//             $js = <<< SCRIPT
//             $(".panelDatos").hide();
//             $(".panelDatos").attr('data-sw', false);
//             $('.field-citasmedicas-hora_llegada').append('<a href="#" id="hora" class="btn btn-default">Colocar hora</a>');
//             $(document).on('click', '#hora', function(event) {
//                 event.preventDefault();
//                 var hora = new Date();
//                 var hours = hora.getHours() < 10 ? '0' + hora.getHours() : hora.getHours();
//                 var minutes = hora.getMinutes() < 10 ? '0' + hora.getMinutes() : hora.getMinutes();
//                 // var seconds = hora.getSeconds() < 10 ? '0' + hora.getSeconds() : hora.getSeconds();
//                 $('#citasmedicas-hora_llegada').val(hours+ ":" +minutes);
//             });
            
// SCRIPT;
//             if($model->hora_llegada == null)
//             {
//                 $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
//             }
            
//             return $this->renderAjax('update', [
//                 'model' => $model,
//                 'paciente'=>Pacientes::findOne($model->pacientes_id),
//                 'id_cliente'=>Usuarios::findOne(Yii::$app->user->id)->idclientes,
//                 'rango_fecha'=>$this->rangoFecha(),
//                 'lista_med'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>$ips])->all(),'id','nombre'),
//                 'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
//                 'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
//                 'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
//                 'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
//                 'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$ips])->all(),'id','nombre'),
//             ]);
//         }
//     }

    /**
     * Updates an existing CitasMedicas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $ips, $num_ips, $med)
    {
        $model = $this->findModel($id);
        $fecha_cita = $model->fecha;
        $hora_cita = $model->hora;
        $paciente = Pacientes::findOne($model->pacientes_id);

        if ($model->load(Yii::$app->request->post())) 
        {
            $paciente->load(Yii::$app->request->post());
            if($model->hora_llegada != null)
            {
                $model->estado = 'PRE';
            }

            if(strtotime($fecha_cita) != strtotime($model->fecha) || strtotime($hora_cita) != strtotime($model->hora))
            {
                if(strtotime($model->fecha) < strtotime(date('Y-m-d')))
                {
                    return 1;
                }
                if((strtotime($model->fecha) == strtotime(date('Y-m-d'))) && (strtotime($model->hora) < strtotime(date('H:i:s'))))
                {
                    return 2;
                }

                if(!$this->validarHoras($model->medicos_id, date('w', strtotime($model->fecha)), substr($model->hora, 0, 5)))
                {
                    return 3;
                }

                if(CitasMedicas::find()->where(['fecha'=>$model->fecha, 'hora'=>$model->hora])->andWhere(['<>', 'id_citas', $model->id_citas])->exists()){
                    return 4;
                }

            }

            if($model->save() && $paciente->save())
            {
                $pac = Pacientes::findOne($model->pacientes_id);
                $medico = Medicos::findOne($model->medicos_id);

                $e['id'] = $model->id_citas;
                $e['start'] = $model->fecha.'T'.$model->hora;
                $e['title'] = $med !== '' ? $pac->nombre1.' '.$pac->nombre2.' '.$pac->apellido1.' '.$pac->apellido2 : $medico->nombre;
                $e['color'] = $med !== '' ? substr(ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$model->estado])->scalar(), 0, 7) : ListasSistema::find()->select(['descripcion'])->where(['id'=>$medico->color])->scalar();
                \Yii::$app->response->format = 'json';

                return $e;
            }else{
                return 0;
            }

        } else {
            $js = <<< SCRIPT
            $(".panelDatos").hide();
            $(".panelDatos").attr('data-sw', false);
            $('.field-citasmedicas-hora_llegada').append('<a href="#" id="hora" class="btn btn-default">Colocar hora</a>');
            $(document).on('click', '#hora', function(event) {
                event.preventDefault();
                var hora = new Date();
                var hours = hora.getHours() < 10 ? '0' + hora.getHours() : hora.getHours();
                var minutes = hora.getMinutes() < 10 ? '0' + hora.getMinutes() : hora.getMinutes();
                // var seconds = hora.getSeconds() < 10 ? '0' + hora.getSeconds() : hora.getSeconds();
                $('#citasmedicas-hora_llegada').val(hours+ ":" +minutes);
            });
            
SCRIPT;
            if($model->hora_llegada == null)
            {
                $this->getView()->registerJs($js, yii\web\View::POS_READY,null);
            }
            
            return $this->renderAjax('update', [
                'model' => $model,
                'paciente'=>Pacientes::findOne($model->pacientes_id),
                'id_cliente'=>Usuarios::findOne(Yii::$app->user->id)->idclientes,
                'rango_fecha'=>$this->rangoFecha(),
                'lista_med'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>$ips])->all(),'id','nombre'),
                'lista_tipoid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_identificacion"')->all(),'codigo','descripcion'),
                'lista_tipos'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_usuario"')->all(),'codigo','descripcion'),
                'lista_resid'=>ArrayHelper::map(ListasSistema::find()->where('tipo="tipo_residencia"')->all(),'codigo','descripcion'),
                'lista_ciudades'=>ArrayHelper::map(Ciudades::find()->all(),'id','nombre'),
                'lista_eps'=>ArrayHelper::map(Eps::find()->where(['idips'=>$ips])->all(),'id','nombre'),
                'motivo'=>ArrayHelper::map(TiposServicio::find()->where(['idips'=>$ips])->all(),'id','nombre'),
            ]);
        }
    }

    public function validarHoras($med, $dia, $hora)
    {
        $medico = Medicos::findOne($med);
        $horario = HorarioMedico::find()->where(['medicos_id'=>$medico->id, 'dia'=>$dia])->one();
        $ips = Ips::findOne($medico->ips_idips);

        if($horario == null)
        {
            return false;
        }

        if(strtotime($hora) >= strtotime($ips->hora_inicio) && strtotime($hora) <= strtotime($ips->hora_fin))
        {
            $horas = explode(',', $horario->horas);
            $horas = implode('-', $horas);
            $horas = explode('-', $horas);

            $temp = false;
            for ($i=0; $i < count($horas); $i = $i + 2) { 
                if(strtotime($hora) >= strtotime($horas[$i]) && strtotime($hora) <= strtotime($horas[$i+1])){
                    $temp = true;
                    break;
                }
            }

            return $temp;

        }else{
            return false;
        }
    }

    /**
     * Cambia la fecha y la hora de una cita.
     * @return mixed
     */
    public function actionCambiarFecha()
    {
        $cita = $this->findModel($_POST['id']);
        $fecha_cita = $cita->fecha;

        if(!$this->validarHoras($_POST['med'], date('w', strtotime($fecha_cita)), substr($_POST['date'], 11, 8) ))
        {
            return 0;
        }

        $cita->estado = 'REP';
        $nueva_cita = new CitasMedicas();
        $nueva_cita->pacientes_id = $cita->pacientes_id;
        $nueva_cita->medicos_id = $cita->medicos_id;
        $nueva_cita->observaciones = $cita->observaciones;
        $nueva_cita->tipo_servicio = $cita->tipo_servicio;
        $nueva_cita->estado = 'NOR';
        $nueva_cita->fecha = substr($_POST['date'], 0, 10);
        $nueva_cita->hora = substr($_POST['date'], 11, 8);


        $temp = CitasMedicas::find()->where(['medicos_id'=>$cita->medicos_id, 'fecha'=>$cita->fecha, 'hora'=>$cita->hora])->andWhere(['<>', 'id_citas', $cita->id_citas])->andWhere(['<>', 'estado', 'REP'])->one();
        if($temp != null){ // Si ya hay una cita con el mismo doctor en esa hora
            return 1;
        }
        if(strtotime($cita->fecha) < strtotime(date('Y-m-d'))) { //Si la fecha es anterior a la fecha actual
            return 2;
        }
        if((strtotime($cita->fecha) == strtotime(date('Y-m-d'))) && (strtotime($cita->hora) < strtotime(date('H:i:s')))) { //Si la fecha y la hora no son anteriores a la fecha y hora actuales
            return 3;
        }

        if($cita->save())
        {
            $nueva_cita->save();
            return $nueva_cita->id_citas;
        }else{
            return 0;
        }

    }

    /**
     * Devuelve las citas de un medico.
     * @return mixed
     */
    public function actionConsultarCitas($id)
    {
        $events = CitasMedicas::find()->where(['medicos_id'=>$id])->andWhere(['<>', 'estado', 'REP'])->andWhere(['<>', 'estado', 'CNL'])->asArray()->all();

        $i = 0;
        foreach ($events as $key => $value) {
            $cita = $this->findModel($value['id_citas']);
            $paciente = Pacientes::find()->where(['id'=>$cita->pacientes_id])->one();
            $t[$i]['id'] = $value['id_citas'];
            $t[$i]['title'] = $paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2;
            $t[$i]['start'] = $value['fecha'].'T'.$value['hora'];
            $t[$i]['color'] = substr(ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$cita->estado])->scalar(), 0, 7);
            $i++;
        }
        $events = $events != null ? json_encode($t) : ''; //Es el formato en que el calendario funciona

        return $events;
    }


    /**
     * Deletes an existing CitasMedicas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel()
    {
        $cita = $this->findModel($_POST['id']);
        $cita->estado = 'CNL';

        if($cita->save()){
            return 'La cita fue cancelada';
        }else{
            return 'No se pudo procesar su solicitud';
        }

    }

    public function actionGetHistoria()
    {
        $hc = HistoriaClinica::find()->select(['id'])->where(['id_paciente'=>$_POST['pac']]);
        $hc2 = HistoriaClinica::find()->where(['id_paciente'=>$_POST['pac']]);
        $paciente = Pacientes::findOne($_POST['pac']);

        // return print_r($ant_pato_l);

        return $this->renderAjax('//historia-clinica/medico',[
                'paciente'=>$paciente,
                'motivo_l'=>MotivoEnfermedad::find()->where(['id_historia'=>$hc])->all(),
                'motivo_e'=>new MotivoEnfermedad(),
                'ant_pato_l'=>AntecedentesPatologicos::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'ant_pato_e'=>new AntecedentesPatologicos(),
                'ant_fam_l'=>AntecedentesFamiliares::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'ant_fam_e'=>new AntecedentesFamiliares(),
                'habitos_l'=>Habitos::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'habitos_e'=>new Habitos(),
                'rev_sis_l'=>RevSistemas::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'rev_sis_e'=> new RevSistemas(),
                'exam_fis_l'=>ExamenFisico::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'exam_fis_e'=>new ExamenFisico(),
                'exp_reg_l'=>ExploracionRegional::find()->where(['id_historia'=>$hc->max('id')])->one(),
                'exp_reg_e'=>new ExploracionRegional(),
                'analisis'=>new AnalisisDiag(),
                'nombre_pac'=>$paciente->nombre1. ' ' .$paciente->nombre2. ' ' .$paciente->apellido1. ' ' .$paciente->apellido2,
            ]);
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

        return $paciente == null ? 0 : $paciente;
    }

    public function meds($esp_id,$ips)
    {
        if($esp_id != 9999){

            $query = (new \yii\db\Query())->select('id,(nombre)AS name')->from('medicos')->where(['idespecialidades'=>$esp_id, 'activo'=>1, 'ips_idips'=>$ips]);
            $r = $query->all();
        }elseif($esp_id == 9999){
            $query = (new \yii\db\Query())->select('id,(nombre)AS name')->from('medicos')->where(['activo'=>1, 'ips_idips'=>$ips]);
            $r = $query->all();
        }
        return $r;

        // return Medicos::find()->select(['id'=>'id','nombre'=>'name'])->where(['idespecialidades'=>$esp_id, 'activo'=>1])->all();
    }

    public function actionSubmed() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $esp = $parents[0];
                $out = $this->meds($esp);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionSubmed2() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $esp = empty($ids[0]) ? null : $ids[0];
            $ips = empty($ids[1]) ? null : $ids[1];
            if ($esp != null) {
               $data = self::meds($esp, $ips);
                // $data =  [
                //        'out'=>[
                //            ['id'=>'1', 'name'=>'<prod-name1>'],
                //            ['id'=>'2', 'name'=>'<prod-name2>']
                //         ],
                //         'selected'=>'1'
                //    ];
                return Json::encode(['output'=>$data, 'selected'=>'']);
                // return Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function rangoFecha()
    {
        $fecha = date('Y');
        $fecha_min = strtotime('-85 year', strtotime($fecha));
        $fecha_max = strtotime('-0 year', strtotime($fecha));
        $fecha_min = date('Y', $fecha_min);
        $fecha_max = date('Y', $fecha_max);

        return $fecha_min.':'.$fecha_max;
    }

    public function actionCodDiag($q = null, $id = null)
    {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $query = new Query;
                $query->select(['id'=>'codigo', 'text'=>'CONCAT(codigo, "-" ,descripcion)'])
                    ->from('cod_cie10')
                    ->where(['like','CONCAT(codigo, "-" ,descripcion)',$q])
                    ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }
            elseif ($id > 0) {
                $cod = CodCie10::findOne($id);
                $out['results'] = ['id' => $id, 'text' => $cod->descripcion.' - '.$cod->descripcion];
            }
            return $out;
    }

}
