<?php

namespace app\controllers;

use Yii;
use app\models\Procedimientos;
use app\models\Ips;
use app\models\ProcedimientosSearch;
use app\models\ColumnasInformes;
use app\models\Usuarios;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

/**
 * FacturasController implements the CRUD actions for Informes model.
 */
class FacturasController extends Controller
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
                        'actions' => ['index','facturacion','facturar','imprimir-facturados','subeps'],
                        'roles' => ['facturacion'],
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

    public function actionIndex()
    {
        $procedimientos = new Procedimientos();
        $ips = new Ips();
        $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');

        return $this->render('index', [
            'lista_ips'=>$lista_ips,
            'ips'=>$ips,
            'procedimientos'=>$procedimientos,
            'fact'=>1,
        ]);
    }

    public function firmados($proc, $ips)
    {
        $query = ' FROM procedimientos t 
        INNER JOIN eps ON t.eps_ideps = eps.id
        INNER JOIN ips ON ips.id = eps.idips INNER JOIN pacientes p ON t.idpacientes=p.id 
        WHERE ips.idclientes='. Usuarios::findOne(Yii::$app->user->id)->idclientes;

        $query .= ' AND eps.idips='.$ips->id.' AND t.eps_ideps='.$proc->eps_ideps.' AND t.estado="'.$proc->estado.'" AND (t.fecha_salida BETWEEN "'.$proc->fecha_inicio.'" AND "'.$proc->fecha_fin.'")';

        return $query;
    }

    public function facturados($proc, $ips) //Arma parte de la consulta para listar los estudios facturados
    {
        $query = 'FROM procedimientos t 
        INNER JOIN eps ON t.eps_ideps = eps.id
        INNER JOIN ips ON ips.id = eps.idips INNER JOIN pacientes p ON t.idpacientes=p.id 
        WHERE ips.idclientes='. Usuarios::findOne(Yii::$app->user->id)->idclientes;

        if($ips->id == 'empty' || $ips->id == null || $ips->id == ''){
            $ips_id = '';
        }else{
            $ips_id = ' AND eps.idips='.$ips->id;
        }

        if($proc->eps_ideps == 'empty' || $proc->eps_ideps == null || $proc->eps_ideps == ''){
            $eps_id = '';
        }else{
            $eps_id = ' AND eps.id='.$proc->eps_ideps;
        }

        if(($proc->fecha_inicio == 'empty' || $proc->fecha_fin == 'empty') || ($proc->fecha_inicio == null || $proc->fecha_fin == null) || ($proc->fecha_inicio == '' || $proc->fecha_fin == '')){
            $fecha = '';
        }else{
            $fecha = ' AND periodo_facturacion between "'.$proc->fecha_inicio.'" AND "'.$proc->fecha_fin.'"';
        }

        $query .= $fecha.' AND (t.estado= "FCT" OR t.estado="IMP")'.$ips_id.$eps_id;
        $query .= ' GROUP BY t.numero_factura';
        

        return $query;
    }

    public function actionFacturacion()
    {
        $proc = new Procedimientos();
        $ips = new Ips();
        if($proc->load(Yii::$app->request->post()) && $ips->load(Yii::$app->request->post())){
       
            $ips = Ips::findOne($_POST['Ips']['id']);
            if($proc->estado == 'FCT'){
                $query = $this->facturados($proc,$ips);
                $campos = ['0'=>'Fecha', '1'=>'Factura', '2'=>'EPS', '3'=>'IPS', '4'=>'TOTAL'];
                $select = 'SELECT (t.id) AS id, t.valor_procedimiento, t.valor_copago, t.descuento, (DATE_FORMAT(t.periodo_facturacion,"%d %b %y")) 
                AS FECHA, (t.numero_factura) AS FACTURA, (eps.nombre) AS EPS, (ips.nombre) AS IPS, (sum(t.valor_saldo)-sum(t.valor_copago)) 
                AS TOTAL, (ips.id) AS IDIPS, (eps.id) AS IDEPS ';
                $tipo = 2;
            }else{
                $query = $this->firmados($proc,$ips);
                $campos = ColumnasInformes::find()->where(['idinforme'=>$proc->epsIdeps->idinformes])->all();
                $select = 'SELECT t.id,t.valor_procedimiento,t.valor_copago, t.descuento, t.numero_muestra';
                $tipo = 1;

                foreach ($campos as $c) {
                    $select .=' , '.$c->idcolumna0->campo.' AS '.$c->idcolumna0->alias;
                }
            }
            $query = $select.$query;

            $lista = Yii::$app->db->createCommand($query)->queryAll();


        }
        $lista_ips = ArrayHelper::map(Ips::find()->all(), 'id', 'nombre');
        return $this->render('index',[
                'lista'=>$lista,
                'campos'=>$campos,
                'lista_ips'=>$lista_ips,
                'ips'=>$ips,
                'procedimientos'=>$proc,
                'tipo'=>$tipo,
                'fecha_inicio'=>$proc->fecha_inicio,
                'fecha_fin'=>$proc->fecha_fin,
                'fact'=>false, //variable para mostrar el boton de facturar
            ]);
    }

    public function actionFacturar($ips, $eps, $fecha_inicio, $fecha_fin, $lista)
    {
        $lista = json_decode($lista);
        $ips = Ips::findOne($ips);
        $num_fac = $ips->consecutivo_fact;
        $ips->consecutivo_fact++;
        $ips->save(false);
            
      
        foreach ($lista as $l) {
            $model = Procedimientos::find()->where(['numero_muestra'=>$l->numero_muestra])->one();
            $model->numero_factura = $num_fac;
            $model->estado = 'FCT';
            $model->periodo_facturacion = date('y-m-d');
            $model->save(false);
        }

       
        $campos = ColumnasInformes::find()->where(['idinforme'=>$model->epsIdeps->idinformes])->all();

        $proc = Procedimientos::find()->where(['numero_muestra'=>$lista[0]->numero_muestra])->one();
        

        $valor = 0;
        $num = 0;
        $desc = 0;
        foreach ($lista as $l) {
            $num++;
            $valor += ($l->valor_procedimiento - $l->valor_copago);
            $desc += $l->valor_procedimiento * ($l->descuento / 100);
        }
        $proc->valor_procedimiento = $valor;
        $proc->cantidad_muestras = $num;
        $proc->descuento = $desc;


        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;
        $mpdf->WriteHtml($this->render('factura_datos',[
                'model'=>$proc,
            ]));
        $mpdf->AddPage();
        $mpdf->WriteHtml($this->render('factura_tablas', [
            'campos'=>$campos,
            'lista'=>$lista,
            'tipo'=>1,
            'fact'=>true,
            'ips'=>$ips,
            'procedimientos'=>$proc,
         ]));
        $mpdf->output();
    }

    public function actionImprimirFacturados($fac,$id_ips,$id_eps)
    {
        $cliente =  Usuarios::findOne(Yii::$app->user->id)->idclientes;
        $query = '  FROM procedimientos t INNER JOIN eps ON t.eps_ideps = eps.id 
                    INNER JOIN ips ON ips.id = eps.idips INNER JOIN pacientes p 
                    ON t.idpacientes=p.id WHERE ips.idclientes='.$cliente;
        $query .= ' AND t.numero_factura="'.$fac.'"';
        $query .= ' AND eps.idips='.$id_ips.' AND t.eps_ideps='.$id_eps;

        $proc = Procedimientos::find()->where(['numero_factura'=>$fac])->one();

        $campos = ColumnasInformes::find()->where(['idinforme'=>$proc->epsIdeps->idinformes])->all();

        $select = 'SELECT t.id,t.valor_procedimiento,t.valor_copago, t.descuento, t.numero_muestra';

        foreach ($campos as $c) {
            $select .=' , '.$c->idcolumna0->campo.' AS '.$c->idcolumna0->alias;
        }

        $query = $select.$query;


        $lista = Yii::$app->db->createCommand($query)->queryAll();

        // return print_r($lista);

        $valor = 0;
        $num = 0;
        $desc = 0;
        foreach ($lista as $l) {
            $num++;
            $valor += ($l['valor_procedimiento'] - $l['valor_copago']);
            $desc += $l['valor_procedimiento'] * ($l['descuento'] / 100);
        }
        $proc->valor_procedimiento = $valor;
        $proc->cantidad_muestras = $num;
        $proc->descuento = $desc;

        $this->layout = 'resultados_layout';
        $pdf = new Pdf();
        $mpdf = $pdf->api;
        $mpdf->WriteHtml($this->renderPartial('factura_datos',[
                'model'=>$proc,
            ]));
        $mpdf->AddPage();
        $mpdf->WriteHtml($this->render('factura_tablas', [
            'campos'=>$campos,
            'lista'=>$lista,
            'tipo'=>1,
            'fact'=>true,
            'procedimientos'=>$proc,
         ]));
        $mpdf->SetJS('this.print()');
        $mpdf->output();

    }
  
    /**
     * Finds the Procedimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Informes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Procedimientos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function eps($id_ips)
    {
        $query = new Query();
        $query->select('id,(nombre)AS name')->from('eps')->where(['idips'=>$id_ips]);

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
}
