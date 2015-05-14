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

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medForm', 'validateOnType' => true, 'options'=>['enctype' => 'multipart/form-data', 'onsubmit'=>'submitForm']]); ?>
    
     <input type="text" name="url" id="url" hidden>
    <?= $form->field($model, 'ips_idips')->widget(Select2::classname(), [
            'data'=>$lista_ips,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una IPS'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('IPS');
    ?>
    

    <?= $form->field($model, 'idespecialidades')->widget(Select2::classname(), [
            'data'=>$lista_especialidades,
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

     <div class="form-group">
        <label for="" class="control-label col-sm-3">Firma</label>
        <div class="col-sm-6">
            <input id="input-1" name="UploadFormImages[file]" type="file" class="file filestyle" data-buttonName="btn-primary" data-buttonText="Examinar">
        </div>            
    </div><br>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#url').val(getUrlVars());
    });
</script>