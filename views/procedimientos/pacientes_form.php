<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pacientes-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'pacProcForm', 'validateOnType' => true, 'action'=>'pacientes-create']); ?>
    
     <input type="text" name="url" id="url" hidden>
    <?= $form->field($model, 'idclientes')->hiddenInput(['value'=>$model->isNewRecord ? $id_cliente : $model->idclientes])->label('') ?>
    
    <?= $form->field($model, 'tipo_identificacion')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_tipoid),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un tipo de ID'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Tipo de ID');
    ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'nombre1')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'nombre2')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'apellido1')->textInput(['maxlength' => 30]) ?>
    
    <?= $form->field($model, 'apellido2')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'sexo')->dropDownList(['prompt'=>'Seleccione una opción', 'M' => 'Masculino', 'F' => 'Femenino']) ?>

    <?= $form->field($model, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['yearRange'=>$rango_fecha,'changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

    <?= $form->field($model, 'tipo_usuario')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_tipos),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un tipo de usuario'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Tipo de usuario');
    ?>

    <?= $form->field($model, 'tipo_residencia')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_resid),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un tipo de residencia'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Tipo de residencia');
    ?>


    <?= $form->field($model, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

    <?= $form->field($model, 'idciudad')->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_ciudades),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una ciudad'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Ciudad');
    ?>
    
    <?= $form->field($model, 'ideps')->widget(Select2::classname(), [
            'data'=>$lista_eps,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una EPS'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Eps');
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'envia_email')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Enviar email') ?>


    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#url').val(getUrlVars());
    });
</script>
