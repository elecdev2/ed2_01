<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicosRemitentesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medicos Remitentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-remitentes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Medicos Remitentes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'codigo',
            'nombre',
            'telefono',
            'email:email',
            // 'especialidades_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
