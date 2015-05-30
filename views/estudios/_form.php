<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'infForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <?= $form->field($model, 'cod_cups')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 150]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
