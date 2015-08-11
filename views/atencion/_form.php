<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atencion-form">
    

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'ateForm', 'validateOnType' => true]); ?>
    
    <input type="text" hidden value="<?=$model->isNewRecord ?>" id="nuevo_registro">
    <div class="panelFormulario-contenido">
        <div class="panelFormulario-header">
            <h3 class="titulo-tarifa">Datos del paciente</h3>
        </div>
        <div class="modal-body">

			<?= $form->field($paciente_model, 'identificacion')->textInput(['maxlength' => 15]) ?>

			<?= $form->field($paciente_model, 'tipo_identificacion')->widget(Select2::classname(), [
                    'data'=>$lista_tipoid,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione un tipo de ID'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Tipo de ID');
            ?>
            <?= $form->field($paciente_model, 'nombre1')->textInput(['maxlength' => 30]) ?>

            <?= $form->field($paciente_model, 'nombre2')->textInput(['maxlength' => 30]) ?>

            <?= $form->field($paciente_model, 'apellido1')->textInput(['maxlength' => 30]) ?>

            <?= $form->field($paciente_model, 'apellido2')->textInput(['maxlength' => 30]) ?>

            <?= $form->field($paciente_model, 'sexo')->widget(Select2::classname(), [
                    'data'=>['M'=>'Masculino', 'F'=>'Femenino'],
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una opción'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Sexo');
            ?>
            
            <?= $form->field($paciente_model, 'direccion')->textInput(['maxlength' => 100]) ?>

            <?= $form->field($paciente_model, 'tipo_usuario')->widget(Select2::classname(), [
                    'data'=>$lista_tipos,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione un tipo de usuario'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Tipo de usuario');
            ?>

            <?= $form->field($paciente_model, 'tipo_residencia')->widget(Select2::classname(), [
                    'data'=>$lista_resid,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione un tipo de residencia'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Tipo de residencia');
            ?>

            <?= $form->field($paciente_model, 'idciudad')->widget(Select2::classname(), [
                    'data'=>$lista_ciudades,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una ciudad'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Ciudad');
            ?>

            <?= $form->field($paciente_model, 'ideps')->widget(Select2::classname(), [
                    'data'=>$lista_eps,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una EPS'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Eps');
            ?>

            <?= $form->field($paciente_model, 'telefono')->textInput(['maxlength' => 15]) ?>
            
            <?= $form->field($paciente_model, 'email')->textInput(['maxlength' => 100]) ?>

            <?= $form->field($paciente_model, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['yearRange'=>$rango_fecha, 'changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
            
            <?= $form->field($paciente_model, 'envia_email')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Enviar email') ?>

        </div>
    </div>

    <div class="panelFormulario-contenido">
        <div class="panelFormulario-header">
            <h3 class="titulo-tarifa">Datos del procedimiento</h3>
        </div>
        <div class="modal-body">

        	<?= $form->field($model, 'fecha_atencion')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['yearRange'=>$rango_fecha, 'changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
            
            <?= $form->field($cita_model, 'hora_llegada')->textInput(['type'=>'time', 'step'=>1])->label('Hora de llegada') ?>

        	<?= $form->field($ips_model, 'id')->widget(Select2::classname(), [
                    'data'=>$ips_list,
                    'language' => 'es',
                    'options' => ['id'=>'ips_id','placeholder' => 'Seleccione una IPS'],
                ])->label('IPS');
            ?>
            

            <?= $form->field($model, 'idmedico')->widget(DepDrop::classname(), [
                        'type' => 2,
                        'data'=>$model->isNewRecord ? '' : [$model->idmedico => $model->idmedico0->nombre],
                        'pluginOptions'=>[
                        'depends'=>['ips_id'],
                        'placeholder'=>'Seleccione un médico',
                        'url'=>Url::to(['/atencion/submed'])
                    ]
                ])->label('Médico tratante');
            ?>

            <?= $form->field($model, 'eps_ideps')->widget(DepDrop::classname(), [
	                    'type' => 2,
	                    'data'=>$model->isNewRecord ? '' : [$model->eps_ideps => $model->epsIdeps->nombre],
	                    'options'=>['id'=>'eps_id'],
	                    'pluginOptions'=>[
	                    'depends'=>['ips_id'],
	                    'placeholder'=>'Seleccione EPS',
	                    'url'=>Url::to(['/atencion/subeps'])
                	]
            	])->label('EPS');  
            ?>

            <?= $form->field($model, 'idtipo_servicio')->widget(DepDrop::classname(), [
                        'type' => 2,
                        'data'=>$model->isNewRecord ? '' : [$model->idtipo_servicio => $model->idtipoServicio->nombre],
                        'options'=>['id'=>'tipo_id'],
                        'pluginOptions'=>[
                        'depends'=>['ips_id', 'eps_id'],
                        'placeholder'=>'Seleccione tipo de estudio',
                        'url'=>Url::to(['/atencion/subtipo'])
                    ]
                ])->label('Tipo de servicio');  
            ?>
			
			<?= $form->field($model, 'cod_cups')->widget(DepDrop::classname(), [
                        'type' => 2,
                        'data'=>$model->isNewRecord ? '' : [$model->cod_cups => $model->codCups->descripcion],
                        'pluginOptions'=>[
                        'depends'=>['ips_id', 'eps_id', 'tipo_id'],
                        'placeholder'=>'Seleccione un estudio',
                        'url'=>Url::to(['/atencion/subest'])
                    ]
                ])->label('Estudio');
            ?>
			
			<?= $form->field($model, 'valor_procedimiento')->textInput(['class'=>'form-control saldo'])->label('Valor del procedimiento  $') ?>

			<?= $form->field($model, 'descuento')->textInput(['readOnly'=>'']) ?>
                    
            <?= $form->field($model, 'valor_copago')->textInput()->label('Valor del copago  $') ?>
        
            <?= $form->field($model, 'valor_abono')->textInput(['class'=>'form-control saldo'])->label('Valor del abono  $') ?>

            <?= $form->field($model, 'valor_saldo')->textInput(['readOnly'=>''])->label('Valor del saldo  $') ?>

            <?= $form->field($model, 'medico')->widget(Select2::classname(), [
                    'data'=>$lista_med,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una opción'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Médico remitente');
            ?>

            <?= $form->field($model, 'observaciones')->textArea(['rows'=>'4', 'maxlength' => 200]) ?>

			<?= $form->field($model, 'forma_pago')->widget(Select2::classname(), [
                    'data'=>$lista_pago,
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una forma de pago'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Forma de pago');
            ?>
        </div>
    </div>
    
     <div class="panel panel-default">
        <div class="panel-body" style="padding: 10px 0;"> 
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $js = <<<SCRIPT

$('form#ateForm').on('beforeSubmit', function(e)
{
    var \$form = $(this);
    var sw = $('#nuevo_registro').val();

    $.post(
        \$form.attr("action"), 
        \$form.serialize()
    )
    .done(function(result) {
        if(result == '0')
        {
            notification('Error al guardar los cambios', 2);
        }else{
            if(sw == 1)
            {
                notification('Se guardaron los cambios', 1);
                $('form').find("input, textarea, select").val("");

                $('#pacientes-tipo_identificacion').select2('val', '');
                $('#pacientes-sexo').select2('val', '');
                $('#pacientes-tipo_usuario').select2('val', '');
                $('#pacientes-tipo_residencia').select2('val', '');
                $('#pacientes-idciudad').select2('val', '');
                $('#pacientes-ideps').select2('val', '');
                $('#procedimientos-idmedico').select2('val', '');
                $('#ips_id').select2('val', '');
                $('#procedimientos-medico').select2('val', '');
                $('#procedimientos-forma_pago').select2('val', '');
            }else{
                $(document).find('#updateModal').modal('hide');
                notification('Se guardaron los cambios', 1);
            }

        }
    })
    .fail(function(){
        notification("Server error", 2);
    });
    return false;
});

SCRIPT;
$this->registerJs($js);

?>
