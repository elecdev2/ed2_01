<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MedicosRemitentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-remitentes-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medRemForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>
    
    <input type="text" name="url" id="url" hidden>  
    <div class="help-block help-block-error "></div>
    <?= $form->field($ips_model, 'id')->dropDownList(ArrayHelper::map($ips_list,'id','nombre'), ['name'=>'ips', 'prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'especialidades_id')->widget(Select2::classname(), [
                'data'=>$lista_especialidades,
                'language' => 'es',
                'class'=>'medField',
                // 'disabled'=>true,
                'options' => ['name'=>'especialidad', 'placeholder' => 'Seleccione una especialidad'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Especialidades');
        ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
