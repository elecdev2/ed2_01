<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ClientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre'])->label(''); ?>
    </div>

    <div class="col-sm-6 col-lg-6">
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

    <!-- <?//echo $form->field($model, 'tema') ?> -->

    <!-- <?//echo $form->field($model, 'tipo_consecutivo') ?> -->

   <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
