<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IpsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'idclientes',
            'codigo',
            'nombre',
            'direccion',
            'tipo_identificacion',
            'nit',
            'telefono',
            'activo',
            // 'consecutivo_fact',
            // 'representante_legal',
            // 'consecutivo_recibo',
            // 'descripcion',
            // 'mensaje_email:email',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear ips', ['create'], ['class' => 'btn btn-success']),
            ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-home"></i>  Ips',
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
