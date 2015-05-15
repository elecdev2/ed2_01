<?php 
namespace app\controllers;

use Yii;
use app\models\Procedimientos;
use app\models\Pacientes;
use app\models\Ips;
use app\models\Recibos;
use app\models\Usuarios;
use app\models\ListasSistema;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
 ?>

 <?php 
/**
 * ReportesController implements the CRUD actions for Informes model.
 */
class ReportesController extends Controller
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
                        'roles' => ['super_admin'],
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

// ----------------------Indexes ---------------------------//

    public function actionIndex($t)
    {
        $procedimientos = new Procedimientos();
        $ips = new Ips();
        $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');

        return $this->render('index', [
            'lista_ips'=>$lista_ips,
            'ips'=>$ips,
            'procedimientos'=>$procedimientos,
            'accion'=>$t == 1 ? 'reporte-estudios' : 'reporte-saldos',
            'titulo'=>$t == 1 ? 'Consultar muestras' : 'Saldos pendientes',
        ]);
    }

    public function actionRips()
    {
        $procedimientos = new Procedimientos();
        $ips = new Ips();
        $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');
        $lista_rips = ArrayHelper::map(ListasSistema::find()->where(['tipo'=>'rips'])->all(), 'id', 'descripcion');
        return $this->render('rips', [
            'lista_ips'=>$lista_ips,
            'ips'=>$ips,
            'procedimientos'=>$procedimientos,
            'lista_rips'=>$lista_rips,
        ]);
    }


    public function actionReporteEstudios()
    {
	 	$proc = new Procedimientos();
        $ips = new Ips();
        if($proc->load(Yii::$app->request->post()) && $ips->load(Yii::$app->request->post()))
        {
            $proc->fecha_atencion = $proc->fecha_inicio;
        	$lista = Recibos::find()
        	->join('INNER JOIN', 'procedimientos p', 'p.id = recibos.idprocedimiento')
        	->join('INNER JOIN', 'eps', 'p.eps_ideps = eps.id')
        	->join('INNER JOIN', 'ips', 'ips.id = eps.idips')
        	->where(['ips.idclientes'=>Usuarios::findOne(Yii::$app->user->id)->idclientes]);

        	if($proc->idtipo_servicio != null && $proc->idtipo_servicio != 'empty'){
        		$lista->andWhere(['p.idtipo_servicio'=>$proc->idtipo_servicio]);
        	}
        	if($ips->id != null && $ips->id != 'empty'){
        		$lista->andWhere(['eps.idips'=>$ips->id]);
        	}
            if ($proc->estado != null && $proc->estado != 'empty') {
                $lista->andWhere(['procedimientos.estado'=>$proc->estado]);
            }
        	if($proc->eps_ideps != null || $proc->eps_ideps != 'empty'){
        		$lista->andWhere(['p.eps_ideps'=>$proc->eps_ideps]);
        	}
        	if($proc->fecha_inicio != null && $proc->fecha_fin != null){
    			$fecha_ini = $proc->fecha_inicio != null ? $proc->fecha_inicio : '1990-01-01';
                $fecha_fin = $proc->fecha_fin != null ? $proc->fecha_fin : date('Y-m-d');

                if ($fecha_ini > date('Y-m-d')) {

                    $proc->addError('fecha_inicio', 'No puede ser superior a la fecha actual');
                }
                if ($fecha_fin > date('Y-m-d')) {

                    $proc->addError('fecha_fin', 'No puede ser superior a la fecha actual');
                }
                if ($fecha_ini > $fecha_fin) {

                    $proc->addError('fecha_inicio', 'No puede ser superior a la fecha final');
                }

                $lista->andWhere(['between','recibos.fecha',$fecha_ini,$fecha_fin]);
        	}


            if(count($proc->errors) == 0){
                $lista->orderBy('recibos.fecha');
                $lista = $lista->all();
                // return print_r($lista);

                $this->imprimirPDF('reporte_estudios',$proc,$lista);
        	}
            return $this->actionIndex(1);
        }
    }

    public function actionReporteSaldos()
    {
        $proc = new Procedimientos();
        $ips = new Ips();
        if($proc->load(Yii::$app->request->post()) && $ips->load(Yii::$app->request->post()))
        {
            $proc->estado = $_POST['Procedimientos']['estado'];
            $proc->fecha_atencion = $proc->fecha_inicio;
            $lista = Procedimientos::find()->select('procedimientos.*,(case when valor_copago > valor_abono then valor_copago - valor_abono else valor_saldo end) AS valor_saldo')
            ->join('INNER JOIN', 'eps', 'procedimientos.eps_ideps = eps.id')
            ->join('INNER JOIN', 'ips', 'ips.id = eps.idips')
            ->where(['ips.idclientes'=>Usuarios::findOne(Yii::$app->user->id)->idclientes]);

            if($proc->idtipo_servicio != null && $proc->idtipo_servicio != 'empty'){
                $lista->andWhere(['procedimientos.idtipo_servicio'=>$proc->idtipo_servicio]);
            }
            if($ips->id != null && $ips->id != 'empty'){
                $lista->andWhere(['eps.idips'=>$ips->id]);
            }
            if ($proc->estado != null && $proc->estado != 'empty') {
                $lista->andWhere(['procedimientos.estado'=>$proc->estado]);
            }
            if($proc->eps_ideps != null || $proc->eps_ideps != 'empty'){
                $lista->andWhere(['procedimientos.eps_ideps'=>$proc->eps_ideps]);
            }
            if($proc->fecha_atencion != null && $proc->fecha_salida != null){
                $fecha_ini = $proc->fecha_atencion != null ? $proc->fecha_atencion : '1990-01-01';
                $fecha_fin = $proc->fecha_salida != null ? $proc->fecha_salida : date('Y-m-d');

                if ($fecha_ini > date('Y-m-d')) {

                    $proc->addError('fecha_atencion', 'No puede ser superior a la fecha actual');
                }
                if ($fecha_fin > date('Y-m-d')) {

                    $proc->addError('fecha_salida', 'No puede ser superior a la fecha actual');
                }
                if ($fecha_ini > $fecha_fin) {

                    $proc->addError('fecha_atencion', 'No puede ser superior a la fecha final');
                }

                $lista->andWhere(['between','procedimientos.fecha_atencion',$fecha_ini,$fecha_fin]);
            }
            $cond1 ='procedimientos.valor_copago > 0 AND procedimientos.valor_copago > procedimientos.valor_abono';
            $cond2 ='procedimientos.valor_copago = 0 AND procedimientos.valor_abono != 0 AND procedimientos.valor_saldo != 0';
            $lista->andWhere(['OR', $cond1, $cond2]);


            if(count($proc->errors) == 0){
                $lista->orderBy('procedimientos.fecha_atencion');
                $lista = $lista->all();
                // return print_r($lista);
                $this->imprimirPDF('reporte_saldos',$proc,$lista);
            }

        }
        return $this->actionIndex(2);
    }

    public function actionReporteRips()
    {
        $proc = new Procedimientos();
        $ips = new Ips();
        if($proc->load(Yii::$app->request->post()) && $ips->load(Yii::$app->request->post()))
        {
            //TODO consultas para los diferentes RIPS
        }
    }

    public function imprimirPDF($titulo,$proc,$lista)
    {
        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;
        $mpdf->WriteHtml($this->render($titulo, [
                'lista'=>$lista,
                'model'=>$proc,
            ]));
        $mpdf->output(date('ymd').'_'.$titulo.'.pdf', Pdf::DEST_DOWNLOAD);
    }

    public function eps($id_ips)
    {
        $query = new Query();
        $query->select('id,(nombre)AS name')->from('eps')->where(['idips'=>$id_ips]);

        return $query->all();
    }

    public function tipos_s($id_ips, $id_eps)
    {
        $query = new Query();
        $query->select('ts.id,(ts.nombre)AS name')->from('tipos_servicio ts')
        ->join('INNER JOIN', 'eps_tipos ep','ep.tipos_servicio_id = ts.id')
        ->join('INNER JOIN', 'eps e','e.id = ep.eps_id')
        ->join('INNER JOIN', 'ips i','i.id = e.idips')
        ->where(['e.id'=>$id_eps]);

        return $query->all();
    }

    public function actionSubeps() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $ips_id = $parents[0];
                $out = $this->eps($ips_id);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionSubtipo() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $ips_id = empty($ids[0]) ? null : $ids[0];
            $eps_id = empty($ids[1]) ? null : $ids[1];
            if ($ips_id != null) {
               $data = self::tipos_s($ips_id, $eps_id);
              
                return Json::encode(['output'=>$data, 'selected'=>'']);
                // return Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

}


  ?>