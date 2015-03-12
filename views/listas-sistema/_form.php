<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use app\models\ListasSistema;

/* @var $this yii\web\View */
/* @var $model app\models\ListasSistema */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="listas-sistema-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

	<?= $form->field($model, 'tipo')->dropDownList([ListasSistema::rips => ListasSistema::rips, ListasSistema::tipo_identificacion => ListasSistema::tipo_identificacion, ListasSistema::tipo_usuario => ListasSistema::tipo_usuario, ListasSistema::tipo_residencia => ListasSistema::tipo_residencia, ListasSistema::estado_prc => ListasSistema::estado_prc, ListasSistema::concepto_fact => ListasSistema::concepto_fact, ListasSistema::tipo_campo => ListasSistema::tipo_campo]); ?>
    <!-- <?= $form->field($model, 'tipo')->textInput(['maxlength' => 45]) ?> -->

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 45])->label('Código *') ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 100])->label('Descripción *') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    	<?= Html::a('Cancelar', ['listas-sistema/index'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
