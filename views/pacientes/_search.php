<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PacientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pacientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tipo_identificacion') ?>

    <?= $form->field($model, 'identificacion') ?>

    <?= $form->field($model, 'apellido1') ?>

    <?= $form->field($model, 'nombre1') ?>

    <?php // echo $form->field($model, 'nombre2') ?>

    <?php // echo $form->field($model, 'apellido2') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'sexo') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento') ?>

    <?php // echo $form->field($model, 'tipo_usuario') ?>

    <?php // echo $form->field($model, 'tipo_residencia') ?>

    <?php // echo $form->field($model, 'idclientes') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'idciudad') ?>

    <?php // echo $form->field($model, 'ideps') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'envia_email') ?>

    <?php // echo $form->field($model, 'codeps') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
