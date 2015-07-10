<?php

use yii\helpers\Html;
use yii\helpers\Url;

// use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Eps */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eps-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'epsForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>
    
     <input type="text" name="url" id="url" hidden>
     <div class="help-block help-block-error "></div>

    <?= $form->field($model, 'idips')->dropDownList($lista_ips, ['prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'nit')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'generar_rip')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Generar RIP?') ?>

    <?= $form->field($model, 'idinformes')->widget(Select2::classname(), [
            'data'=>$lista_informes,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un informe'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Informe');
    ?>

    <?= $form->field($model, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

    
    <?= $form->field($model, 'tipos_est')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'language' => 'es',
            // 'id'=>'listaEst',
            // 'name'=>'tipos_estudios',
            'options'=> ['multiple' => true], 
            'pluginOptions' => [
                'depends'=>['ips_id'],
                'allowClear' => true,
                'tags'=>true,
                'placeholder'=>'Seleccione las opciones',
                'url'=>Url::to(['/eps/subtipos'])
            ],
        ])->label('Tipos de estudios');
    ?>
        

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#url').val(getUrlVars());

        $('#eps-tipos_est').on('change', function(e){
            var val = $('#eps-tipos_est option:selected');
            if(val.attr('value') === '')
                val.remove();
        });
    });
</script>
