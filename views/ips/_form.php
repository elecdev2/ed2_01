<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ips-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'idclientes')->widget(Select2::classname(), [
            'data' => array_merge(["" => ""], $list_client),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un cliente'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Cliente *'); 
    ?>

    <!-- <?= $form->field($model, 'idclientes')->dropDownList($list_client,['prompt'=>'Seleccione una opción'])->label('Cliente *');?> -->
    <!-- <?= $form->field($model, 'idclientes')->textInput() ?> -->

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15])->label('Código *') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150])->label('Ips *') ?>

    <?= $form->field($model, 'descripcion')->textArea(['maxlength' => 100]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'tipo_identificacion')->dropDownList($listdata,['prompt'=>'Seleccione una opción']);?>

    <!-- <?= $form->field($model, 'tipo_identificacion')->textInput(['maxlength' => 3]) ?> -->

    <?= $form->field($model, 'nit')->textInput(['maxlength' => 15])->label('Nit *') ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 30])->label('Teléfono *') ?>

    <?= $form->field($model, 'consecutivo_fact')->textInput()->label('Consecutivo de factura *') ?>
    
    <?= $form->field($model, 'consecutivo_recibo')->textInput()->label('Consecutivo de recibo *') ?>

    <?= $form->field($model, 'representante_legal')->textInput(['maxlength' => 100])->label('Representante legal *') ?>
    
    <?= $form->field($model, 'mensaje_email')->textArea(['maxlength' => 1000]) ?>

    <?= $form->field($model, 'activo')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Activo *') ?>
    <!-- <?= $form->field($model, 'activo')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class''btn btn-success']) ?>
        <?= Html::a('Cancelar', ['ips/index'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
