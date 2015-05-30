<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\CamposSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-4">
     <?= $form->field($model, 'idtipos_servicio', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>$lista_tipos,
            'language' => 'es',
            'options' => ['placeholder' => 'Tipos de estudio'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'tipo_campo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Tipo de campo'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'nombre_campo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre de campo'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'titulos_idtitulos', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Titulo'])->label('') ?>
    </div>

    <?php // echo $form->field($model, 'orden') ?>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
