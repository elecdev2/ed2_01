<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'cod_cups')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 150]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['informes/index'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
