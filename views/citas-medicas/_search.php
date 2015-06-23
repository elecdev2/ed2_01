<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-medicas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_citas') ?>

    <?= $form->field($model, 'pacientes_id') ?>

    <?= $form->field($model, 'medicos_id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'hora') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
