<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'fecha_atencion',
            'numero_muestra',
            'eps_ideps',
            'idpacientes',
            'cod_cups',
            'valor_procedimiento',
            'numero_factura',
            'estado',
            // 'autorizacion',
            // 'cantidad_muestras',
            // 'valor_copago',
            // 'valor_saldo',
            // 'valor_abono',
            // 'medico',
            // 'observaciones',
            // 'forma_pago',
            // 'numero_cheque',
            // 'fecha_informe',
            // 'fecha_salida',
            // 'fecha_entrega',
            // 'periodo_facturacion',
            // 'idtipo_servicio',
            // 'idmedico',
            // 'usuario_recibe',
            // 'usuario_transcribe',
            // 'descuento',
            // 'idbackup',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear procedimiento', ['create'], ['class' => 'btn btn-success'])
            ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-list-alt"></i>  Procedimientos',
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
