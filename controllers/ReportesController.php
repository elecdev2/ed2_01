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
use yii\data\ActiveDataProvider;

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
            'cerrar'=>1,
        ]);
    }

    public function actionRips()
    {
        $procedimientos = new Procedimientos();
        $ips = new Ips();
        $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');
        $lista_rips = ArrayHelper::map(ListasSistema::find()->where(['tipo'=>'rips'])->all(), 'codigo', 'descripcion');
        return $this->render('rips', [
            'lista_ips'=>$lista_ips,
            'ips'=>$ips,
            'procedimientos'=>$procedimientos,
            'lista_rips'=>$lista_rips,
            'cerrar'=>1,
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
                $lista->andWhere(['p.estado'=>$proc->estado]);
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


            $dataProvider = new ActiveDataProvider([
                'query' => $lista,
                'sort'=>false,
            ]);

            if(count($proc->errors) == 0){
                // $lista->orderBy('recibos.fecha');
                // $lista = $lista->all();

                $ips = new Ips();
                $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');
                $procedimientos = new Procedimientos();
                return $this->render('index',[
                        'dataProvider'=>$dataProvider,
                        'lista_ips'=>$lista_ips,
                        'ips'=>$ips,
                        'procedimientos'=>$procedimientos,
                        'accion'=>'reporte-estudios',
                        'titulo'=>'Consultar muestras',
                        'tabla'=>1,
                        'cerrar'=>2,
                    ]);

                //$this->imprimirPDF('reporte_estudios',$proc,$lista);
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

            $dataProvider = new ActiveDataProvider([
                'query' => $lista,
                'sort'=>false,
            ]);            

            if(count($proc->errors) == 0){

                $ips = new Ips();
                $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');
                $procedimientos = new Procedimientos();
                return $this->render('index',[
                        'dataProvider'=>$dataProvider,
                        'lista_ips'=>$lista_ips,
                        'ips'=>$ips,
                        'procedimientos'=>$procedimientos,
                        'accion'=>'reporte-saldos',
                        'titulo'=>'Saldos pendientes',
                        'tabla'=>2,
                        'cerrar'=>2,
                    ]);

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
            $id_cliente = Usuarios::findOne(Yii::$app->user->id)->idclientes;
            $query = new Query();
            switch ($proc->fecha_fin) //fecha_fin tiene el valor del tipo de reporte rips
            { 
                case 'AF':
                    $query->select(['i.codigo AS codigoips', 'i.nombre AS nombreips', 'i.tipo_identificacion AS tipoid_ips', 'i.nit', 't.numero_factura', 't.periodo_facturacion', 'DATE_FORMAT(t.periodo_facturacion, "%d/%m/%y") AS periodo_facturacion','DATE_FORMAT(LAST_DAY(t.periodo_facturacion), "%d/%m/%y") AS fecha_fin', 'e.codigo', 'e.nombre', 'SUM(t.valor_copago) AS copago', 'SUM(t.valor_procedimiento) AS valor_procedimiento'])
                    ->from('procedimientos t')
                    ->join('INNER JOIN', 'eps e', 't.eps_ideps = e.id')
                    ->join('INNER JOIN', 'ips i', 'i.id = e.idips')
                    ->where(['i.idclientes'=>$id_cliente]);
                    break;
                case 'AP':
                    $query->select(['CONCAT(p.nombre1," ",p.nombre2," ",p.apellido1," ",p.apellido2) AS nombre', 'p.tipo_identificacion', 'p.identificacion', 'DATE_FORMAT(t.fecha_atencion, "%d/%m/%y") AS fecha_atencion', 'DATE_FORMAT( LAST_DAY( t.fecha_atencion), "%d/%m/%y") AS fecha_fin', 'e.codigo', 'DATE_FORMAT(t.periodo_facturacion, "%d/%m/%y") AS periodo_facturacion', 't.numero_factura', 'i.nit', 'i.tipo_identificacion AS tipoid_ips', 'i.codigo AS codips', 'i.nombre AS nombre_ips', 'e.nombre', 't.valor_copago', 't.valor_saldo', 't.autorizacion', 't.cod_cups', 't.valor_procedimiento'])
                    ->from('procedimientos t')
                    ->join('INNER JOIN', 'eps e', 't.eps_ideps = e.id')
                    ->join('INNER JOIN', 'ips i', 'e.idips = i.id')
                    ->join('INNER JOIN', 'pacientes p', 't.idpacientes = p.id')
                    ->where(['i.idclientes'=>$id_cliente]);
                    break;
                case 'US':
                    $query->select(['CONCAT(p.nombre1," ",p.nombre2," ",p.apellido1," ",p.apellido2) AS nombre', 'p.*', 'e.codigo', 'DATE_FORMAT((YEAR(CURDATE())-YEAR(p.fecha_nacimiento) ), "%d/%m/%y") AS edad', 'c.codigo AS ciudad', 'c.codigo_departamento AS departamento'])
                    ->from('pacientes p')
                    ->join('INNER JOIN', 'procedimientos t', 't.idpacientes = p.id')
                    ->join('INNER JOIN', 'eps e', 'p.ideps = e.id')
                    ->join('INNER JOIN', 'ciudades c', 'p.idciudad = c.id')
                    ->where(['p.idclientes'=>$id_cliente]);
                    break;
                default:
                    $query->select(['COUNT(t.numero_muestra) AS PF', 'i.codigo AS codips']);
                    break;
            }
            $subQuery = (new Query())->select(['COUNT(p.id)'])->from('pacientes p')
            ->join('INNER JOIN', 'procedimientos t', 't.idpacientes = p.id')
            ->join('INNER JOIN', 'eps e', 'p.ideps = e.id')
            ->join('INNER JOIN', 'ciudades c', 'p.idciudad = c.id')
            ->where(['p.idclientes'=>$id_cliente]);

            if($proc->fecha_fin == 'CT'){
                $query->addSelect([$subQuery])
                ->from('procedimientos t')
                ->join('INNER JOIN', 'eps e', 't.eps_ideps = e.id')
                ->join('INNER JOIN', 'ips i', 'i.id = e.idips')
                ->join('INNER JOIN', 'pacientes p', 't.idpacientes = p.id')
                ->where(['i.idclientes'=>$id_cliente]);
            }

            $sql = $this->whereCondition($query,$proc,$ips);

            if(count($proc->errors) == 0)
            {
                $lista = $sql->all();
                if(count($lista) > 0)
                {
                    switch ($proc->fecha_fin) 
                    {
                        case 'AF':
                            $text = $this->lineasArchivoAF($lista);
                            break;
                        case 'AP':
                            $text = $this->lineasArchivoAP($lista);
                            break;
                        case 'US':
                            $text = $this->lineasArchivoUS($lista);
                            break;
                        default:
                            $text = $this->lineasArchivoCT($lista);
                            break;
                    }
                    // $this->download($proc->fecha_fin. date('Y-m-d'). '.txt', $text);
                    return \Yii::$app->response->sendContentAsFile($text, $proc->fecha_fin. date('Y-m-d'). '.txt');
                }else{
                    $m = 'No hay registros con las condiciones seleccionadas';
                }
            }
        }
        $this->actionRips();
    }

    public function download($titulo,$content)
    {
        $headers = Yii::$app->response->headers;
        $headers->set('Content-Disposition', 'attachment; filename='.$titulo);
        $headers->set('Content-Type', 'text/txt');
        Yii::$app->response->content = $content;
        return;
    }

    public function lineasArchivoAF($lista)
    {   
        $texto = '';
        foreach ($lista as $l) {
            $texto .= $l['codigoips'] . ',' . $l['nombreips'] . ',' . $l['tipoid_ips'] . ',' . $l['nit'] . ',' . $l['numero_factura'] . ',' . $l['periodo_facturacion'] . ',' .
                    '01'. substr($l['periodo_facturacion'], 2) . ',' . $l['fecha_fin'] . ',' . $l['codigo'] . ',' . $l['nombre'] . ',' . ',' . ',' . ','.
                    $l['copago'] . ',' . ',' . ',' . $l['valor_procedimiento'] . "\r\n";
        }
        return $texto;
    }
    public function lineasArchivoAP($lista)
    {   
        $texto = '';
        foreach ($lista as $l) {
            $texto .= $l['numero_factura'] . ',' . $l['codips'] . ',' . $l['tipo_identificacion'] . ',' . $l['identificacion'] . ',' . $l['fecha_atencion'] . ',' .
                    $l['autorizacion'] . ',' . $l['cod_cups'] . ',1,1,1' . ',' . ',' . ',' . ',' . ',' . $l['valor_procedimiento'] . "\r\n";
        }
        return $texto;
    }
    public function lineasArchivoUS($lista)
    {   
        $texto = '';
        foreach ($lista as $l) {
            $texto .= $l['tipo_identificacion'] . ',' . $l['identificacion'] . ',' . $l['codigo'] . ',' .
                    $l['tipo_usuario'] . ',' . $l['apellido1'] . ',' . $l['apellido2'] . ',' . $l['nombre1'] . ',' . $l['nombre2'] . ',' .
                    $l['edad'] . ',1' . ',' . $l['sexo'] . ',' . $l['departamento'] . ',' . $l['ciudad'] . ',' . $l['tipo_residencia'] . "\r\n";
        }
        return $texto;
    }
    public function lineasArchivoCT($lista, $month, $year, $fecha_ini)
    {   
        $texto = '';
        foreach ($lista as $l) {
            $texto .= $l['codips'] . ',' . '01/'.$month . '/'.$year .',AP' .substr($fecha_ini, 5,6).substr($fecha_ini, 0,4). ',' . $l['PF'] . PHP_EOL.
                      $l['codips'] . ',' . '01/'.$month . '/'.$year .',US' .substr($fecha_ini, 5,6).substr($fecha_ini, 0,4). ',' . $l['2'] . PHP_EOL.
                      $l['codips'] . ',' . '01/'.$month . '/'.$year .',AF' .substr($fecha_ini, 5,6).substr($fecha_ini, 0,4). ',' . $l['PF'] . PHP_EOL;
        }
        return $texto;
    }

    public function whereCondition($query,$proc,$ips)
    {
        if($ips->id != null && $ips->id != 'empty')
        {
            $query->andWhere(['e.idips'=>$ips->id]);
        }
        if($proc->eps_ideps != null && $proc->eps_ideps != 'empty')
        {
            $query->andWhere(['e.id'=>$proc->eps_ideps]);
        }
        // if($proc->estado != null && $proc->estado != 'empty')
        // {
        //     $query->andWhere(['t.estado'=>$proc->estado]);
        // }
        if($proc->fecha_atencion != null && $proc->fecha_atencion != 'empty')
        {
            $fecha_ini = $proc->fecha_atencion != null ? $proc->fecha_atencion : '1990-01';
            if($fecha_ini >= date('Y-m'))
            {
                $proc->addError('fecha_atencion', 'El periodo de RIPS debe ser menor a la fecha actual');
            }
            $periodo = explode("-", $fecha_ini);
            $year=$periodo[1]=='12'?intval($periodo[0])+1:$periodo[0];
            $month=$periodo[1]=='12'?'01':intval($periodo[1])+1;   
            $cur_month=$periodo[1]=='12'?'01':intval($periodo[1]);

            $query->andWhere(['between', 't.periodo_facturacion', $year.'-'.$cur_month.'-01', $year.'-'.$month.'-05']); 
            $query->andWhere(['t.estado'=>'FCT']);
        }

        return $query;
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
