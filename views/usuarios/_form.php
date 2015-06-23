<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'usuarioForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <input type="text" name="url" id="url" hidden>
    <?= $form->field($model, 'idclientes')->hiddenInput(['value'=>$model->isNewRecord ? $id_cliente: $model->idclientes])->label('') ?>


    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Hombre', 'F' => 'Mujer'],['prompt'=>'Seleccione una opción'])->label('Sexo') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'perfil')->widget(Select2::classname(), [
            'data'=>$lista_perf,
            'id'=>'perfiles',
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un perfil'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                "change" => $model->isNewRecord ? "function() { 
                                                    if($(this).val() == 'medico'){
                                                            $('#panelMedico').show();
                                                            $('#campoIPSs').hide();
                                                        }else{
                                                            $('#panelMedico').hide();
                                                            $('#campoIPSs').show();
                                                        } 
                                                    }" :
                                                    "function() { 
                                                            $('#campoIPSs').hide();
                                                            $('#panelMedico').hide();
                                                    }",
                                                   
            ],
        ])->label('Perfil');
    ?>

    
    <div id="campoIPSs">
        <?= $form->field($ipsModel, 'id')->widget(Select2::classname(), [
                    'data'=>$lista_ips,
                    'language' => 'es',
                    'id'=>'medField',
                    'options' => ['placeholder' => '','multiple'=>true,],
                    'pluginOptions' => [
                        'tags' => true,
                        'allowClear' => true,
                    ],
                ])->label('IPSs');
            ?>
    </div>

    <div id="panelMedico"  class="">
        <?= $form->field($model, 'ips_medico')->widget(Select2::classname(), [
                'data'=>$lista_ips,
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione una IPS'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('IPS');
        ?>


        <?= $form->field($model, 'especialidad')->widget(Select2::classname(), [
                'data'=>$lista_especialidades,
                'language' => 'es',
                // 'disabled'=>true,
                'options' => ['placeholder' => 'Seleccione una especialidad'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Especialidad');
        ?>

        <?= $form->field($model, 'codigo_medico')->textInput()->label('Código') ?>

    </div>
    <?= $form->field($model, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#panelMedico').hide();
    });
</script>
