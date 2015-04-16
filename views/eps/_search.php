<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\EpsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eps-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'idips', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Tipo de ID']); ?>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código']); ?>
</div>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre']); ?>
</div>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'direccion', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Dirección']); ?>
</div>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'telefono', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Teléfono']); ?>
</div>
<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nit', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'NIT']); ?>
</div>

    <?php // echo $form->field($model, 'generar_rip', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Tipo de ID']); ?>

<div class="col-sm-6 col-lg-4">
    <?php // echo $form->field($model, 'idinformes', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Tipo de ID']); ?>
</div>

    <?php // echo $form->field($model, 'activo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Activo']); ?>

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
