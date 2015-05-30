<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EspecialidadesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="especialidades-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código'])->label('') ?>
    </div>
    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre'])->label('') ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
