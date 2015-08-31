<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'pjax'=>true,
        'columns' => [
            'codigoips',
            'nombreips',
            'tipoid_ips',
            'nit',
            'numero_factura',
            'periodo_facturacion',
            'fecha_fin',
            'codigo',
            'nombre',
            'copago',
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
