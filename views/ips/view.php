<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'codigo',
            'nombre',
            'direccion',
            'tipo_identificacion',
            'nit',
            'telefono',
            'idclientes',
            'activo',
            'consecutivo_fact',
            'representante_legal',
            'consecutivo_recibo',
            'descripcion',
            'mensaje_email:email',
        ],
    ]) ?>

</div>
