<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 100])->label('Cliente *') ?>

    <!-- <?= $form->field($model, 'activo')->textInput() ?> -->

    <?= $form->field($model, 'tema')->textInput(['maxlength' => 45]) ?>
	
	<?= $form->field($model, 'activo')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Activo *') ?>

    <!-- <?= $form->field($model, 'tipo_consecutivo')->textInput(['maxlength' => 1]) ?> -->

    <?= $form->field($model, 'tipo_consecutivo')->dropDownList(['prompt'=>'Seleccione una opción', 'G' => 'General', 'E' => 'Especifico']); ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['clientes/index'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
