<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ListasSistemaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="listas-sistema-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'descripcion', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Descripción'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'tipo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Tipo'])->label('') ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
