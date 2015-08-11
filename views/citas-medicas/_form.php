<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-medicas-form">

<?php if(!$model->isNewRecord){ ?>

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'citasForm', 'validateOnType' => true]); ?>

        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Datos de la cita</h3>
            </div>
            <div class="modal-body">
                <?= $form->field($paciente, 'idclientes')->hiddenInput(['value'=>$paciente->isNewRecord ? $id_cliente : $paciente->idclientes])->label('') ?>

               <?= $form->field($model, 'medicos_id')->widget(Select2::classname(), [
                        'data'=>$lista_med,
                        'language' => 'es',
                        'readonly'=>true, 
                        'options' => ['placeholder' => 'Seleccione una opción'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Médico');
                ?>


                <?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

                <?= $form->field($model, 'hora')->textInput(['type'=>'time']) ?>

                <?= $form->field($model, 'tipo_servicio')->widget(Select2::classname(), [
                        'data'=>$motivo,
                        'language' => 'es',
                        'readonly'=>true, 
                        'options' => ['placeholder' => 'Seleccione una opción'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Motivo');
                ?>

                <?= $form->field($model, 'observaciones')->textArea(['cols'=>50,'rows'=>4, 'maxlength' => true]) ?>


                <input type="text" hidden name="url" value="<?=$model->isNewRecord ? 0 : $model->medicos_id?>">
                
                
                <div class="text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="">

            <div class="panelFormulario-contenido">
                <div class="panelFormulario-header">
                    <h3 class="titulo-tarifa">Datos del paciente</h3>
                </div>
                <div class="modal-body">

                    <!-- <div class="form-group">
                        <label class="control-label col-sm-3">N° de ID del paciente *</label>
                        <div class="col-sm-6">
                            <input id="documento_cita" name="documento_cita" type="number" required oninput="getPaciente()" class="form-control" value="<?= $model->isNewRecord ? '' : $model->pacientes->identificacion?>">
                        </div>
                    </div>
 -->
                    <?= $form->field($paciente, 'identificacion')->textInput(['maxlength' => 15]) ?>

                    <?= $form->field($paciente, 'tipo_identificacion')->widget(Select2::classname(), [
                            'data'=>$lista_tipoid,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de ID'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de ID');
                    ?>

                    <?= $form->field($paciente, 'nombre1')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'nombre2')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'apellido1')->textInput(['maxlength' => 30]) ?>
                    
                    <?= $form->field($paciente, 'apellido2')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'direccion')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($paciente, 'telefono')->textInput(['maxlength' => 15]) ?>

                    <?= $form->field($paciente, 'sexo')->dropDownList(['prompt'=>'Seleccione una opción', 'M' => 'Masculino', 'F' => 'Femenino']) ?>

                    <?= $form->field($paciente, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$paciente->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['yearRange'=>$rango_fecha,'changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

                    <?= $form->field($paciente, 'tipo_usuario')->widget(Select2::classname(), [
                            'data'=>$lista_tipos,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de usuario'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de usuario');
                    ?>

                    <?= $form->field($paciente, 'tipo_residencia')->widget(Select2::classname(), [
                            'data'=>$lista_resid,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de residencia'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de residencia');
                    ?>


                    <?= $form->field($paciente, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

                    <?= $form->field($paciente, 'idciudad')->widget(Select2::classname(), [
                            'data'=>$lista_ciudades,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una ciudad'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Ciudad');
                    ?>
                    
                    <?= $form->field($paciente, 'ideps')->widget(Select2::classname(), [
                            'data'=>$lista_eps,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una EPS'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Eps');
                    ?>

                    <?= $form->field($paciente, 'email')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($paciente, 'envia_email')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Enviar email') ?>
                   
                   <div class="text-center">
                        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>


    <?php ActiveForm::end(); ?>
<?php }else{ ?>

<?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'citasForm', 'validateOnType' => true]); ?>


        <div class="">

            <div class="panelFormulario-contenido">
                <div class="panelFormulario-header">
                    <h3 class="titulo-tarifa">Datos del paciente</h3>
                </div>
                <div class="modal-body">

                   <!--  <div class="form-group">
                        <label class="control-label col-sm-3">N° de ID del paciente *</label>
                        <div class="col-sm-6">
                            <input id="documento_cita" name="documento_cita" type="number" required oninput="getPaciente()" class="form-control" value="<?= $model->isNewRecord ? '' : $model->pacientes->identificacion?>">
                        </div>
                    </div> -->

                    <?= $form->field($paciente, 'identificacion')->textInput(['maxlength' => 15]) ?>

                    <?= $form->field($paciente, 'tipo_identificacion')->widget(Select2::classname(), [
                            'data'=>$lista_tipoid,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de ID'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de ID');
                    ?>

                    <?= $form->field($paciente, 'nombre1')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'nombre2')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'apellido1')->textInput(['maxlength' => 30]) ?>
                    
                    <?= $form->field($paciente, 'apellido2')->textInput(['maxlength' => 30]) ?>

                    <?= $form->field($paciente, 'direccion')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($paciente, 'telefono')->textInput(['maxlength' => 15]) ?>

                    <?= $form->field($paciente, 'sexo')->widget(Select2::classname(), [
                            'data'=>['M'=>'Masculino', 'F'=>'Femenino'],
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una opción'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Sexo');
                    ?>

                    <?= $form->field($paciente, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$paciente->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['yearRange'=>$rango_fecha,'changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

                    <?= $form->field($paciente, 'tipo_usuario')->widget(Select2::classname(), [
                            'data'=>$lista_tipos,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de usuario'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de usuario');
                    ?>

                    <?= $form->field($paciente, 'tipo_residencia')->widget(Select2::classname(), [
                            'data'=>$lista_resid,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de residencia'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de residencia');
                    ?>


                    <?= $form->field($paciente, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

                    <?= $form->field($paciente, 'idciudad')->widget(Select2::classname(), [
                            'data'=>$lista_ciudades,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una ciudad'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Ciudad');
                    ?>
                    
                    <?= $form->field($paciente, 'ideps')->widget(Select2::classname(), [
                            'data'=>$lista_eps,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una EPS'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Eps');
                    ?>

                    <?= $form->field($paciente, 'email')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($paciente, 'envia_email')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Enviar email') ?>
                   
                </div>
            </div>
        </div>
        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Datos de la cita</h3>
            </div>
            <div class="modal-body">
                <?= $form->field($paciente, 'idclientes')->hiddenInput(['value'=>$paciente->isNewRecord ? $id_cliente : $paciente->idclientes])->label('') ?>

               <?= $form->field($model, 'medicos_id')->widget(Select2::classname(), [
                        'data'=>$lista_med,
                        'language' => 'es',
                        'readonly'=>true, 
                        'options' => ['placeholder' => 'Seleccione una opción'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Médico');
                ?>


                <?= $form->field($model, 'fecha')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

                <?= $form->field($model, 'hora')->textInput(['type'=>'time']) ?>

                <?= $form->field($model, 'tipo_servicio')->widget(Select2::classname(), [
                        'data'=>$motivo,
                        'language' => 'es',
                        'readonly'=>true, 
                        'options' => ['placeholder' => 'Seleccione una opción'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Motivo');
                ?>

                <?= $form->field($model, 'observaciones')->textArea(['cols'=>50,'rows'=>4, 'maxlength' => true]) ?>


                <input type="text" hidden name="url" value="<?=$model->isNewRecord ? 0 : $model->medicos_id?>">
                
                
                
               <div class="text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
                </div>
            </div>
        </div>


    <?php ActiveForm::end(); ?>

<?php } ?>
</div>

<?php 
    $js = <<<SCRIPT

$('form#citasForm').on('beforeSubmit', function(e)
{
    var \$form = $(this);
    var sw = $('input[name="url"]').val() == 0 ? true : false;
    $.post(
        \$form.attr("action"), 
        \$form.serialize()
    )
    .done(function(result) {
        if(result == 0)
        {
            notification('Error al guardar los cambios', 2);
        }else{
            
            if(sw){

                $(document).find('#citasModal').modal('hide');
                $('.fullcalendar').fullCalendar( 'renderEvent', result, true);
                bootbox.alert('Se guardaron los cambios');
            }else{
                switch (result) {
                    case '1':
                        notification('Error: La fecha es anterior al día de hoy ', 2);
                        break;

                    case '2':
                        notification('Error: La hora es anterior a la hora actual ', 2);
                        break;

                    case '3':
                        notification('Error: El médico no atiende en ese horario ', 2);
                        break;

                    case '4':
                        notification('Error: Ya existe una cita en ese día y hora ', 2);
                        break;
                    
                    default:
                        $(document).find('#citasModal').modal('hide');
                        var event = result;
                        $('.fullcalendar').fullCalendar( 'removeEvents', event.id);
                        $('.fullcalendar').fullCalendar( 'renderEvent', result, true);
                        notification('Se guardaron los cambios', 1);
                        break;
                }
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