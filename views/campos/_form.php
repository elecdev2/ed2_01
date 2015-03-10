<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Campos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idtipos_servicio')->textInput() ?>

    <?= $form->field($model, 'tipo_campo')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'nombre_campo')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'titulos_idtitulos')->textInput() ?>

    <?= $form->field($model, 'orden')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
