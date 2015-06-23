<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use app\models\TiposServicio;
use yii\bootstrap\ActiveForm;
use app\models\Ips;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'procForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>
        
                <div class="panelFormulario-contenido">
                    <div class="panelFormulario-header">
                        <h3 class="titulo-tarifa">Datos del paciente</h3>
                    </div>
                    <div class="modal-body">
                        <?= $form->field($model, 'idpacientes')->hiddenInput()->label('') ?>

                        <?php if(!$model->isNewRecord){ ?>
                            <?= $form->field($paciente_model, 'identificacion')->textInput(['value'=>$model->idpacientes0->identificacion, 'maxlength' => 15]) ?>
                        <?php }else{ ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3">N° de identificación *</label>
                                <div class="col-sm-6">                
                                    <input id="documento" type="number" required class="form-control" value="<?= $model->isNewRecord ? '' : $model->idpacientes0->identificacion?>">
                                </div>
                            </div>
                        <?php } ?>


                        
                            
                            <?= $form->field($paciente_model, 'tipo_identificacion')->dropDownList($lista_tipoid, ['prompt'=>'', 'id'=>'tipoID'])->label('Tipo de ID');?>

                            <?= $form->field($paciente_model, 'nombre1')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->nombre1, 'maxlength' => 30]) ?>

                            <?= $form->field($paciente_model, 'nombre2')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->nombre2, 'maxlength' => 30]) ?>

                            <?= $form->field($paciente_model, 'apellido1')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->apellido1, 'maxlength' => 30]) ?>

                            <?= $form->field($paciente_model, 'apellido2')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->apellido2, 'maxlength' => 30]) ?>
                            
                            <?= $form->field($paciente_model, 'direccion')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->direccion, 'maxlength' => 100]) ?>

                            <?= $form->field($paciente_model, 'telefono')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->telefono, 'maxlength' => 15]) ?>
                            
                            <?= $form->field($paciente_model, 'email')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->email, 'maxlength' => 100]) ?>
                            
                <!-- --> <?= $form->field($paciente_model, 'codeps')->textInput()->label('Edad') ?> <!-- Campo usado para la edad -->

                            <?= $form->field($paciente_model, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->isNewRecord ? '' : $model->idpacientes0->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
                        </div>
                    </div>
                
            

        
                <div class="panelFormulario-contenido">
                    <div class="panelFormulario-header">
                        <h3 class="titulo-tarifa">Datos del procedimiento</h3>
                    </div>
                    <div class="modal-body">
        
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" name="url" id="url" hidden>
                                <div class="help-block help-block-error "></div>
                            </div>
                        </div>
                        <?= $form->field($model, 'fecha_atencion')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->isNewRecord ? date('Y-m-d') : $model->fecha_atencion, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
                    
                            
                        <?= $form->field($ips_model, 'id')->dropDownList(ArrayHelper::map($ips_list,'id','nombre'), ['prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

                    
                        <?= $form->field($model, 'eps_ideps')->widget(DepDrop::classname(), [
                                'type' => 2,
                                'data'=>$model->isNewRecord ? '' : [$model->eps_ideps => $model->epsIdeps->nombre],
                                'options'=>['id'=>'eps_id'],
                                'pluginOptions'=>[
                                'depends'=>['ips_id'],
                                'placeholder'=>'Seleccione EPS',
                                'url'=>Url::to(['/procedimientos/subeps'])
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
                                    'url'=>Url::to(['/procedimientos/subtipo'])
                                ]
                            ])->label('Tipo de servicio');  
                        ?>
                    
                    

                    
                        <?= $form->field($model, 'cod_cups')->widget(DepDrop::classname(), [
                                    'type' => 2,
                                    'data'=>$model->isNewRecord ? '' : [$model->cod_cups => $model->codCups->descripcion],
                                    'pluginOptions'=>[
                                    'depends'=>['ips_id', 'eps_id', 'tipo_id'],
                                    'placeholder'=>'Seleccione un estudio',
                                    'url'=>Url::to(['/procedimientos/subest'])
                                ]
                            ])->label('Estudio');
                        ?>
                    
                    

                    
                        <?= $form->field($model, 'autorizacion')->textInput(['maxlength' => 15]) ?>
                    
                    
                        <?= $form->field($model, 'cantidad_muestras')->textInput() ?>
                    
                    
                        <?= $form->field($model, 'valor_procedimiento')->textInput() ?>

                        <?= $form->field($model, 'descuento')->textInput(['readOnly'=>'']) ?>
                    
                        <?= $form->field($model, 'valor_copago')->textInput() ?>
                    
                        <?= $form->field($model, 'valor_abono')->textInput() ?>

                        <?= $form->field($model, 'valor_saldo')->textInput(['readOnly'=>'']) ?>
                    
                    
                        <?= $form->field($model, 'medico')->widget(Select2::classname(), [
                                'data'=>$lista_med,
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione una opción'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Médico remitente');
                        ?>
                    
                    
                        <?= $form->field($model, 'observaciones')->textArea(['maxlength' => 200]) ?>
                    

                        <?= $form->field($model, 'forma_pago')->widget(Select2::classname(), [
                                'data'=>$lista_pago,
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione una forma de pago'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Forma de pago');
                        ?>

                        <?php if(!$model->isNewRecord && $model->estado !== 'PND'){  ?>
                               <?= $form->field($model, 'fecha_salida')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>                                                                                                                                                                                                                         
                        <?php } ?>

                    </div>
                </div>


                <?php if(!$model->isNewRecord && ($model->estado !== 'FCT' && $model->estado !== 'IMP')){ ?>
                        <div class="panelFormulario-contenido">
                            <div class="panelFormulario-header">
                                <h3 class="titulo-tarifa"><?=TiposServicio::find()->select('nombre')->where(['id'=>$model->idtipo_servicio])->scalar()?></h3>
                            </div>
                            <div class="modal-body">
                                <?= $this->render('form_estudios', [
                                        'campos'=>$campos,
                                        'model'=>$model,
                                        'form'=>$form,
                                        'imp'=>0,
                                ]) ?>
                            </div>
                        </div>
                <?php } ?>  


                    <div class="panel panel-default">
                        <div class="panel-body" style="padding: 10px 0;"> 

                            <?php if($model->estado == 'PND' || $model->estado == 'PRC') {?>
                                    <div class="col-sm-6" style="padding: 5px 10px;">
                                        <input type="checkbox" name="checkEstado">
                                        <label for="checkEstado" style="font-size:1.25em;"><?= $model->estado == 'PND' ? 'Procesar' : 'Firmar' ?></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['style'=>'float:right', 'class' =>'btn btn-success']) ?>
                                    </div>
                            <?php }else{ ?>

                                <div class="text-center">
                                    <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                
        
                


    <?php ActiveForm::end(); ?>

</div>



<div id="pacienteModal" class="modal fade bs-example-modal-sm" data-backdrop="true" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt=""></button>
                <h3 class="modal-title">Registrar paciente</h3>
            </div>
            <div class="modal-body">
                <?php if($model->isNewRecord){ ?>
                   <?= $this->render('pacientes_create', [
                        'model' => $paciente_model,
                        'lista_tipos'=>$lista_tipos,
                        'lista_tipoid'=>$lista_tipoid,
                        'lista_resid'=>$lista_resid,
                        'lista_ciudades'=>$lista_ciudades,
                        'lista_eps'=>$lista_eps,
                        'id_cliente'=>$id_cliente,
                        'rango_fecha'=>$rango_fecha
                    ]) ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <div></div>
            </div>
        </div>
    </div>
</div>

<div id="medRemNuevo" class="modal fade bs-example-modal-md" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" onclick="cerrarModal(medRemNuevo)"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="titulo-tarifa">Nuevo médico remitente</h3>
            </div>
            <div class="modal-body">
                <div class="form-group required">
                    <label class="control-label" for="">Médicos remitentes</label><br>
                        <div class="col-sm-10">
                            <?= Select2::widget([
                                    'name' => 'remitentes',
                                    'id'=>'medrem',
                                    'data'=>$lista_medRemGen,
                                    'language' => 'es',
                                    'options' => ['placeholder' => 'Seleccione una opción'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);
                            ?>
                        </div>   
                        <div class="col-sm-2"><a href="" id="agregar" data-dismiss="modal" class="btn btn-default">Añadir</a></div>
                </div><br>

                 <div class="form-group field-medico-check">
                    <div class="col-sm-6">
                        <?= Html::input('checkBox','nombre','',['id'=>'showHidePanel', 'class'=>'']);?>
                        <label for="showHidePanel">Agregar un médico nuevo</label>
                    </div>
                </div><br>

                <div class="panel panel-default">
                    <div id="panelMedico"  class="panel-body">
                        <?=$this->render('//medicos-remitentes/_form', [
                            'model'=>$medicoRemModel,
                            'lista_especialidades'=>$lista_especialidades,
                            'ips_model'=>$ips_model,
                            'ips_list'=>$ips_list,
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#panelMedico').hide();
        $('.field-procedimientos-medico').append('<a href="#" id="medRem" class="btn btn-default">Nuevo médico</a>');
        $('#procedimientos-cod_cups').on('change', function(event) {
            var cod_cup = $(this).val();
            var eps_id = $('#eps_id').val();
            if(cod_cup != ''){
                $.post('precio', {cod: cod_cup, id: eps_id}, function(data) {
                    saldo = data['valor_procedimiento'];
                    $('#procedimientos-valor_procedimiento').val(data['valor_procedimiento']);
                    $('#procedimientos-valor_saldo').val(data['valor_procedimiento']);
                    $('#procedimientos-valor_copago').val(0);
                    $('#procedimientos-valor_abono').val(0);
                    $('#procedimientos-descuento').val(data['descuento']);
                    // console.log(data['valor_procedimiento']);
                });
            }
        });

        $('#procedimientos-valor_abono').on('change', function(event) {
            event.preventDefault();
            var abono = parseFloat($('#procedimientos-valor_abono').val());

            if(isNaN(abono)){
                $('#procedimientos-valor_saldo').val($('#procedimientos-valor_procedimiento').val());
            }else{
                $('#procedimientos-valor_saldo').val($('#procedimientos-valor_procedimiento').val()-abono);
            }
        });

        $('#medRem').on('click', function(event) {
            event.preventDefault();
            $('#medRemNuevo').modal();
        });

        $('#showHidePanel').on('change', function(event) {
            event.preventDefault();
            $('#panelMedico').hide();
            if($('#showHidePanel').is(':checked')){
                $('#panelMedico').show();
            }
        });

    
        $('#agregar').on('click', function(event) {
            event.preventDefault();
            var datos = $('#medrem').val();
            if(datos != ''){
                $.post('add-medico', {data: datos}, function(data) {
                   var datos = jQuery.parseJSON(data); 
                   var newOption = $('<optgroup label="'+datos['especialidad']+'"><option value="'+datos['id']+'">'+datos['nombre']+'</option></optgroup>');
                   $('#procedimientos-medico').append(newOption);
                });
            }
        });

        $('#guardarMedico').on('click', function(event) {
            event.preventDefault();
            var formulario = $('#medRemForm').serialize();
            $('#medRemForm')[0].reset();
            $.post('guardar-medico', {data: formulario}, function(data) {
                var datos = jQuery.parseJSON(data); 
               // console.log(datos['nombre']);
               var newOption = $('<optgroup label='+datos['especialidad']+'><option value="'+datos['id']+'">'+datos['nombre']+'</option></optgroup>');
               $('#procedimientos-medico').append(newOption);
            });

        });

        $('#pacientes-fecha_nacimiento').on('change', function(event) {
            $.post('calcular-edad', {fecha: $(this).val()}).done(function(data) {
                $('#pacientes-codeps').val(data);
            });
        });

        $('#pacientes-codeps').on('change', function(event) {
            $.post('calcular-fecha', {age:$(this).val()}).done(function(data) {
                $('#pacientes-fecha_nacimiento').val(data);
            });
        });

    });
</script>