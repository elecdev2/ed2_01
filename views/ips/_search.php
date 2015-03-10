<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IpsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ips-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'tipo_identificacion') ?>

    <?php // echo $form->field($model, 'nit') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'idclientes') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'consecutivo_fact') ?>

    <?php // echo $form->field($model, 'representante_legal') ?>

    <?php // echo $form->field($model, 'consecutivo_recibo') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'mensaje_email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
