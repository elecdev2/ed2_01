<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\IpsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ips-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre'])->label('') ?>
    </div>

    <!-- <?//echo $form->field($model, 'direccion') ?> -->

    <!-- <?// echo $form->field($model, 'tipo_identificacion') ?> -->

    <!-- <?php // echo $form->field($model, 'nit') ?> -->

    <!-- <?php // echo $form->field($model, 'telefono') ?> -->

    <!-- <?php // echo $form->field($model, 'idclientes') ?> -->
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

    <!-- <?php // echo $form->field($model, 'consecutivo_fact') ?> -->

    <!-- <?php // echo $form->field($model, 'representante_legal') ?> -->

    <!-- <?php // echo $form->field($model, 'consecutivo_recibo') ?> -->

    <!-- <?php // echo $form->field($model, 'descripcion') ?> -->

    <!-- <?php // echo $form->field($model, 'mensaje_email') ?> -->

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
