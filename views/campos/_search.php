<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CamposSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idtipos_servicio') ?>

    <?= $form->field($model, 'tipo_campo') ?>

    <?= $form->field($model, 'nombre_campo') ?>

    <?= $form->field($model, 'titulos_idtitulos') ?>

    <?php // echo $form->field($model, 'orden') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
