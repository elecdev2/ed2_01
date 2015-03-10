<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CamposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campos-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'idtipos_servicio',
            'tipo_campo',
            'nombre_campo',
            // 'titulos_idtitulos',
            // 'orden',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear campo', ['create'], ['class' => 'btn btn-success']),
            ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-list-alt"></i>  Campos',
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
