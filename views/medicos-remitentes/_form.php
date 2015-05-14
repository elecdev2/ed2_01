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

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medRemForm', 'enableAjaxValidation' => true, 'validateOnType' => true]); ?>

    <?= $form->field($ips_model, 'id')->dropDownList(ArrayHelper::map($ips_list,'id','nombre'), ['name'=>'ips', 'prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

    <?= $form->field($model, 'codigo')->textInput(['name'=>'codigo', 'maxlength' => 15]) ?>

    <?= $form->field($model, 'nombre')->textInput(['name'=>'nombre', 'maxlength' => 150]) ?>

    <?= $form->field($model, 'telefono')->textInput(['name'=>'telefono', 'maxlength' => 45]) ?>

    <?= $form->field($model, 'email')->textInput(['name'=>'email', 'maxlength' => 45]) ?>

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
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['data-dismiss'=>'modal', 'id'=>'guardarMedico', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
