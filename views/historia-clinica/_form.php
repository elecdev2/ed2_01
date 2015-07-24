<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistoriaClinica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historia-clinica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_paciente')->textInput() ?>

    <?= $form->field($model, 'id_tipos')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?= $form->field($model, 'id_medico')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
