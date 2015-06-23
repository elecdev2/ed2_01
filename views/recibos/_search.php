<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecibosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recibos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>


    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'num_muestra', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Procedimiento']) ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'num_recibo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Número de recibo']) ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'valor_saldo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'valor saldo']) ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'valor_abono', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'valor abono']) ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'nombre_usuario', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Usuario']) ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'fecha', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
