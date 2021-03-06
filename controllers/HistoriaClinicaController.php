<?php

namespace app\controllers;

use Yii;
use app\models\HistoriaClinica;
use app\models\HistoriaClinicaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\db\Query;

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
use app\models\Pacientes;
use app\models\Recomendaciones;
use app\models\Formulacion;
use app\models\ArchivosHistorial;
use app\models\Procedmientos;
use app\models\VlrsCamposProcedimientos;

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
            $cod = Yii::$app->request->queryParams['HistoriaClinicaSearch']['diag'] !== '' ? Yii::$app->request->queryParams['HistoriaClinicaSearch']['diag'] : 0;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $cod);
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
        $historia = $this->findModel($id);
        $paciente = Pacientes::findOne($historia->id_paciente);
        $analisis = AnalisisDiag::find()->where(['id_historia'=>$historia->id])->one();
        $recomendaciones = Recomendaciones::find()->where(['id_historia'=>$historia->id])->one();
        $formulacion = Formulacion::find()->where(['id_historia'=>$historia->id])->one();

        $historias = HistoriaClinica::find()->select(['id'])->where(['id_paciente'=>$paciente->id]);

        $ant_patologicos = AntecedentesPatologicos::find()->where(['id_historia'=>$historia->id])->one();
        $ant_familiares = AntecedentesFamiliares::find()->where(['id_historia'=>$historia->id])->one();
        $habitos = Habitos::find()->where(['id_historia'=>$historia->id])->one();
        $ex_fisico = ExamenFisico::find()->where(['id_historia'=>$historia->id])->one();

        return $this->renderAjax('view', [
            'model' => $historia,
            'paciente' => $paciente,
            'motivo'=> MotivoEnfermedad::find()->where(['id_historia'=>$historia->id])->one(),
            'ant_patologicos'=> $ant_patologicos == null ? AntecedentesPatologicos::find()->where(['id_historia'=>$historias])->orderBy(['id'=>SORT_DESC])->one() : $ant_patologicos,
            'ant_familiares'=> $ant_familiares == null ? AntecedentesFamiliares::find()->where(['id_historia'=>$historias])->orderBy(['id'=>SORT_DESC])->one() : $ant_familiares,
            'habitos'=> $habitos == null ? Habitos::find()->where(['id_historia'=>$historias])->orderBy(['id'=>SORT_DESC])->one() : $habitos,
            'rev_sistemas'=> RevSistemas::find()->where(['id_historia'=>$historia->id])->one(),
            'ex_fisico'=> $ex_fisico == null ? ExamenFisico::find()->where(['id_historia'=>$historias])->orderBy(['id'=>SORT_DESC])->one() : $ex_fisico,
            'exp_regional'=> ExploracionRegional::find()->where(['id_historia'=>$historia->id])->one(),
            'analisis'=> $analisis == null ? '' : $analisis->analisis,
            'diagnosticos'=> $analisis == null ? null : ArrayHelper::map(CodCie10::find()->where(['codigo'=>AnalisisImpresiondiagnostica::find()->select(['id_cod'])->where(['id_analisis'=>$analisis->id])])->all(), 'codigo', 'descripcion'),
            'recomendaciones'=> $recomendaciones,
            'formulacion' => $formulacion,
            'impresion' => false,
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
    public function actionUpdatee($id)
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

    public function actionConsultarFechas()
    {
        // $hc = HistoriaClinica::find()->select(['id'])->where(['pacientes_id'=>$_POST['pac'], 'fecha'=>$_POST['fecha']])->scalar();
        switch ($_POST['id']) 
        {
            case 'mot_enf':
                \Yii::$app->response->format = 'json';
                $mot_enf = MotivoEnfermedad::find()->where(['id_historia'=>$_POST['hc']])->one();
                $result[0] = $mot_enf->motivo;
                $result[1] = $mot_enf->enfermedad;
                return $result;
                break;
            case 'ant_pat':
                $render = 'antecedentes_pat';
                $query = AntecedentesPatologicos::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'ant_fam':
                $render = 'antecedentes_fam';
                $query = AntecedentesFamiliares::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'hab':
                $render = 'habitos';
                $query = Habitos::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'rev':
                $render = 'revision_sistemas';
                $query = RevSistemas::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'fis':
                $render = 'examen_fisico';
                $query = ExamenFisico::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'exp':
                $render = 'exploracion_regional';
                $query = ExploracionRegional::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'ana':
                
                $analisis = AnalisisDiag::find()->where(['id_historia'=>$_POST['hc']])->one();
                $diagnosticos = $analisis == null ? null : ArrayHelper::map(CodCie10::find()->where(['codigo'=>AnalisisImpresiondiagnostica::find()->select(['id_cod'])->where(['id_analisis'=>$analisis->id])])->all(), 'codigo', 'descripcion');

                return $this->renderAjax('analisis_diagnostico',[
                    'analisis'=>$analisis == null ? '' : $analisis->analisis,
                    'diagnosticos'=>$diagnosticos,
                ]);
                break;
            case 'rec':
                $render = 'recomendaciones';
                $query = Recomendaciones::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'for':
                $render = 'formulacion';
                $query = Formulacion::find()->where(['id_historia'=>$_POST['hc']])->one();
                break;
            case 'arch':
                $render = 'archivos_hist';
                $query = ArrayHelper::map(ArchivosHistorial::find()->where(['id_historia'=>$_POST['hc']])->all(), 'id', 'archivo');
                break;
        }

        return $this->renderAjax($render,[
            'model'=>$query,
        ]);
    }

    public function actionFechasEspecialidad()
    {

        $valores = (new Query())->select(['nombre'=>'campos.nombre_campo', 'valor'=>'vlrs_campos_procedimientos.valor'])
        ->from('procedimientos')
        ->join('INNER JOIN', 'vlrs_campos_procedimientos', 'procedimientos.id = vlrs_campos_procedimientos.id_procedimiento')
        ->join('INNER JOIN', 'campos', 'campos.id = vlrs_campos_procedimientos.idcampos_tipos_servicio')
        ->where(['id_procedimiento'=>$_POST['pr']])->all();

        return $this->renderAjax('especialidad',[
            'model'=>$valores,
        ]);
    }

    public function actionImprimir()
    {
        $keys = $_POST['keys'];
         if(is_array($keys) == 1)
        {
            return $this->redirect(['multiple-imp', 'keys'=>json_encode($keys)]);
        }else{

            return $this->redirect(['imp', 'keys'=>$keys]);
        }
        
    }

    public function actionImp($keys)
    {
        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;
        // $mpdf->showImageErrors = true;

        $historia = $this->findModel($keys);
        $paciente = Pacientes::findOne($historia->id_paciente);
        $analisis = AnalisisDiag::find()->where(['id_historia'=>$historia->id])->one();

        $mpdf->WriteHtml($this->render('view', [
                'model' => $historia,
                'paciente'=>$paciente,
                'motivo'=> MotivoEnfermedad::find()->where(['id_historia'=>$historia->id])->one(),
                'ant_patologicos'=> AntecedentesPatologicos::find()->where(['id_historia'=>$historia->id])->one(),
                'ant_familiares'=> AntecedentesFamiliares::find()->where(['id_historia'=>$historia->id])->one(),
                'habitos'=> Habitos::find()->where(['id_historia'=>$historia->id])->one(),
                'rev_sistemas'=> RevSistemas::find()->where(['id_historia'=>$historia->id])->one(),
                'ex_fisico'=> ExamenFisico::find()->where(['id_historia'=>$historia->id])->one(),
                'exp_regional'=> ExploracionRegional::find()->where(['id_historia'=>$historia->id])->one(),
                'analisis'=> $analisis == null ? '' : $analisis->analisis,
                'diagnosticos'=> $analisis == null ? null : ArrayHelper::map(CodCie10::find()->where(['codigo'=>AnalisisImpresiondiagnostica::find()->select(['id_cod'])->where(['id_analisis'=>$analisis->id])])->all(), 'codigo', 'descripcion'),
                'impresion' => true,
            ], true));
        $mpdf->output($paciente->nombre1.'_'.$paciente->nombre2.'_'.$paciente->apellido1.'_'.$paciente->apellido2.'_'.date('Y-m-d').'.pdf', Pdf::DEST_DOWNLOAD);
        

    }

    public function actionMultipleImp($keys)
    {
        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;

        $keys = json_decode($keys);

        foreach ($keys as $key => $value) 
            {
                $historia = $this->findModel($value);
                $paciente = Pacientes::findOne($historia->id_paciente);
                $analisis = AnalisisDiag::find()->where(['id_historia'=>$historia->id])->one();

                $mpdf->WriteHtml($this->render('view', [
                        'model' => $historia,
                        'paciente'=>$paciente,
                        'motivo'=> MotivoEnfermedad::find()->where(['id_historia'=>$historia->id])->one(),
                        'ant_patologicos'=> AntecedentesPatologicos::find()->where(['id_historia'=>$historia->id])->one(),
                        'ant_familiares'=> AntecedentesFamiliares::find()->where(['id_historia'=>$historia->id])->one(),
                        'habitos'=> Habitos::find()->where(['id_historia'=>$historia->id])->one(),
                        'rev_sistemas'=> RevSistemas::find()->where(['id_historia'=>$historia->id])->one(),
                        'ex_fisico'=> ExamenFisico::find()->where(['id_historia'=>$historia->id])->one(),
                        'exp_regional'=> ExploracionRegional::find()->where(['id_historia'=>$historia->id])->one(),
                        'analisis'=> $analisis == null ? '' : $analisis->analisis,
                        'diagnosticos'=> $analisis == null ? null : ArrayHelper::map(CodCie10::find()->where(['codigo'=>AnalisisImpresiondiagnostica::find()->select(['id_cod'])->where(['id_analisis'=>$analisis->id])])->all(), 'codigo', 'descripcion'),
                    ], true));
                $mpdf->addPage();
            }
            $mpdf->output('historias_.pdf', Pdf::DEST_DOWNLOAD);
    }
    /**
     * Imprime una formulación o una recomendación.
     * @param integer $id
     * @return mixed
     */
    public function actionImprimirRf($id, $t)
    {
        switch ($t) 
        {
            case 'r':
                $model = Recomendaciones::findOne($id)->recomendaciones;
                break;
            case 'f':
                $model = Formulacion::findOne($id)->formulacion;
                break;
          
        }

        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;


        $mpdf->WriteHtml($this->render('recomFor', [
                'model' => $model,
            ], true));
        $mpdf->SetJS('this.print()');
        $mpdf->output();
    }

    /**
     * Devuelve listado de diagnosticos segun criterio de busqueda en el search.
     * @return mixed
     */
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

    /**
     * Deletes an existing HistoriaClinica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletee($id)
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
