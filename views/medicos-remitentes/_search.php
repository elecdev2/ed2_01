<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MedicosRemitentesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-remitentes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'telefono', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Télefono']) ?>
    </div>

        <!-- <?php //echo $form->field($model, 'email', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Email']) ?> -->

    <!-- <?php // echo $form->field($model, 'especialidades_id') ?> -->

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
