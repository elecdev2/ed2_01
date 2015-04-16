<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cod_cups')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 150]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
