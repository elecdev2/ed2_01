<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InformesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Informes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nombre',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear Informe', ['create'], ['class' => 'btn btn-success']),
            ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-file"></i>  Informes',
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
