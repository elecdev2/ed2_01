<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EpsTiposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eps Tipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-tipos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Eps Tipos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipos_servicio_id',
            'eps_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
