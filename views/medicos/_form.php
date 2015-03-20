<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <?= $form->field($model, 'ips_idips')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_ips),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una IPS'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('IPS');
    ?>


    <?= $form->field($model, 'idespecialidades')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_especialidades),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una especialidad'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Especialidades');
    ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15])->label('Código') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'idclientes')->hiddenInput(['value'=>$model->isNewRecord ? $id_cliente: $model->idclientes])->label('') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
