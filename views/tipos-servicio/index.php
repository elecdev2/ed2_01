<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TiposServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-servicio-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nombre',
            'idips',
            'consecutivo',
            'serie',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear tipo de servicio', ['create'], ['class' => 'btn btn-success']),
            ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-home"></i>  Tipos de servicio',
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
