<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-view">

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
            'tipo_identificacion',
            'identificacion',
            'apellido1',
            'nombre1',
            'nombre2',
            'apellido2',
            'direccion',
            'telefono',
            'sexo',
            'fecha_nacimiento',
            'tipo_usuario',
            'tipo_residencia',
            'idclientes',
            'activo',
            'idciudad',
            'ideps',
            'email:email',
            'envia_email:email',
            'codeps',
        ],
    ]) ?>

</div>
