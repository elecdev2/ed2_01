<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstudiosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

     <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'cod_cups', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código cups'])->label('') ?>
    </div>
     <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'descripcion', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre'])->label('') ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
