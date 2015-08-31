<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstudiosIps */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-ips-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cod_cups')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idtipo_servicio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
