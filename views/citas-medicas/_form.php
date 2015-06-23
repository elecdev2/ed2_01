<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-medicas-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'procForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

<div class="panelFormulario-contenido">
    <div class="panelFormulario-header">
        <h3 class="titulo-tarifa">Datos de la cita</h3>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'pacientes_id')->hiddenInput()->label('') ?>

        <div class="form-group">
            <label class="control-label col-sm-3">N° de ID del paciente *</label>
            <div class="col-sm-6">                
                <input id="documento_cita" type="number" required oninput="getPaciente()" class="form-control" value="<?= $model->isNewRecord ? '' : $model->pacientes->identificacion?>">
            </div>
        </div>

        <div class="row text-center">
            <h5 id="pacienteName"></h5>
        </div>


        <?= $form->field($model, 'medicos_id')->widget(Select2::classname(), [
                'data'=>$lista_med,
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione una opción'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Médico');
        ?>

        <?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

        <?= $form->field($model, 'hora')->textInput() ?>

        <?= $form->field($model, 'observaciones')->textArea(['cols'=>50,'rows'=>4, 'maxlength' => true]) ?>

        <div class="text-center">
            <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>

</div>
