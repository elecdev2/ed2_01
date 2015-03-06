<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idpacientes')->textInput() ?>

    <?= $form->field($model, 'fecha_atencion')->textInput() ?>

    <?= $form->field($model, 'autorizacion')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'numero_muestra')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'valor_procedimiento')->textInput() ?>

    <?= $form->field($model, 'eps_ideps')->textInput() ?>

    <?= $form->field($model, 'cod_cups')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'cantidad_muestras')->textInput() ?>

    <?= $form->field($model, 'valor_copago')->textInput() ?>

    <?= $form->field($model, 'valor_saldo')->textInput() ?>

    <?= $form->field($model, 'valor_abono')->textInput() ?>

    <?= $form->field($model, 'medico')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'forma_pago')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'numero_cheque')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'fecha_informe')->textInput() ?>

    <?= $form->field($model, 'numero_factura')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'fecha_salida')->textInput() ?>

    <?= $form->field($model, 'fecha_entrega')->textInput() ?>

    <?= $form->field($model, 'periodo_facturacion')->textInput() ?>

    <?= $form->field($model, 'idtipo_servicio')->textInput() ?>

    <?= $form->field($model, 'idmedico')->textInput() ?>

    <?= $form->field($model, 'usuario_recibe')->textInput() ?>

    <?= $form->field($model, 'usuario_transcribe')->textInput() ?>

    <?= $form->field($model, 'descuento')->textInput() ?>

    <?= $form->field($model, 'idbackup')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
