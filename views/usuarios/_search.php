<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'idmedicos', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Médico']); ?>

    <?php // echo $form->field($model, 'password', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código']); ?>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre']); ?>
</div>

    <?php //echo $form->field($model, 'idclientes', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Cliente']); ?>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'username', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre de usuario']); ?>
</div>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'activo', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>[1 => 'Activo', 2 => 'Inactivo'],
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un estado'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
</div>

    <div class="form-group text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
