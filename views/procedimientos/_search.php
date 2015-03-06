<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcedimientosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idpacientes') ?>

    <?= $form->field($model, 'fecha_atencion') ?>

    <?= $form->field($model, 'autorizacion') ?>

    <?= $form->field($model, 'numero_muestra') ?>

    <?php // echo $form->field($model, 'valor_procedimiento') ?>

    <?php // echo $form->field($model, 'eps_ideps') ?>

    <?php // echo $form->field($model, 'cod_cups') ?>

    <?php // echo $form->field($model, 'cantidad_muestras') ?>

    <?php // echo $form->field($model, 'valor_copago') ?>

    <?php // echo $form->field($model, 'valor_saldo') ?>

    <?php // echo $form->field($model, 'valor_abono') ?>

    <?php // echo $form->field($model, 'medico') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'forma_pago') ?>

    <?php // echo $form->field($model, 'numero_cheque') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fecha_informe') ?>

    <?php // echo $form->field($model, 'numero_factura') ?>

    <?php // echo $form->field($model, 'fecha_salida') ?>

    <?php // echo $form->field($model, 'fecha_entrega') ?>

    <?php // echo $form->field($model, 'periodo_facturacion') ?>

    <?php // echo $form->field($model, 'idtipo_servicio') ?>

    <?php // echo $form->field($model, 'idmedico') ?>

    <?php // echo $form->field($model, 'usuario_recibe') ?>

    <?php // echo $form->field($model, 'usuario_transcribe') ?>

    <?php // echo $form->field($model, 'descuento') ?>

    <?php // echo $form->field($model, 'idbackup') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
