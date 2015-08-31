<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'pjax'=>true,
        'columns' => [
            'nombre_pac',
            'tipo_identificacion',
            'identificacion',
            'fecha_atencion',
            'fecha_fin',
            'codigo',
            'periodo_facturacion',
            'numero_factura',
            'nit',
            'tipoid_ips',
            'codips',
            'nombre_ips',
            'nombre',
            'valor_copago',
            'valor_saldo',
            'autorizacion',
            'cod_cups',
            'valor_procedimiento',
        ],
        'toolbar' => [
            // [
            //     Html::a('Descargar archivo', ['reporte-rips'], ['class' => 'btn btn-success'])
            // ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>