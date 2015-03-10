<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */

$this->title = $model->cod_cups;
$this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cod_cups], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cod_cups], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cod_cups',
            'descripcion',
        ],
    ]) ?>

</div>
