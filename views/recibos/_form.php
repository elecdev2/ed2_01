<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recibos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recibos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idprocedimiento')->textInput() ?>

    <?= $form->field($model, 'num_recibo')->textInput() ?>

    <?= $form->field($model, 'valor_saldo')->textInput() ?>

    <?= $form->field($model, 'valor_abono')->textInput() ?>

    <?= $form->field($model, 'idusuario')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
