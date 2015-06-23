<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'cliForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <input type="text" name="url" id="url" hidden>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 100])->label('Cliente *') ?>

    <!-- <?= $form->field($model, 'activo')->textInput() ?> -->

    <?= $form->field($model, 'tema')->textInput(['maxlength' => 45]) ?>
	
	<?= $form->field($model, 'activo')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Activo *') ?>

    <!-- <?= $form->field($model, 'tipo_consecutivo')->textInput(['maxlength' => 1]) ?> -->

    <?= $form->field($model, 'tipo_consecutivo')->dropDownList(['prompt'=>'Seleccione una opción', 'G' => 'General', 'E' => 'Especifico']); ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
