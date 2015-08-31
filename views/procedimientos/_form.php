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

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'procForm', 'validateOnType' => true]); ?>
        
        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Datos del paciente</h3>
            </div>
            <div class="modal-body">
                <?= $form->field($ips_model, 'id')->widget(Select2::classname(), [
                        'data'=>ArrayHelper::map($ips_list,'id','nombre'),
                        'language' => 'es',
                        'options' => ['id'=>'ips_id','placeholder' => 'Seleccione una IPS'],
                    ])->label('IPS');
                ?>
                <?= $form->field($model, 'idpacientes')->hiddenInput()->label('') ?>

                    <?= $form->field($paciente_model, 'identificacion')->textInput(['maxlength' => 15])->label('Paciente ID *') ?>

                     <?= $form->field($paciente_model, 'tipo_identificacion')->widget(Select2::classname(), [
                            'data'=>$lista_tipoid,
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de ID'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Tipo de ID');
                    ?>

                    <?= $form->field($paciente_model, 'nombre1')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->nombre1, 'maxlength' => 30]) ?>

                    <?= $form->field($paciente_model, 'nombre2')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->nombre2, 'maxlength' => 30]) ?>

                    <?= $form->field($paciente_model, 'apellido1')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->apellido1, 'maxlength' => 30]) ?>

                    <?= $form->field($paciente_model, 'apellido2')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->apellido2, 'maxlength' => 30]) ?>
                    
                    <?= $form->field($paciente_model, 'direccion')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->direccion, 'maxlength' => 100]) ?>

                    <?= $form->field($paciente_model, 'sexo')->widget(Select2::classname(), [
                            'data'=>['M'=>'Masculino', 'F'=>'Femenino'],
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione una opción'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Sexo');
                    ?>

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

                   

                    <?= $form->field($paciente_model, 'ideps')->widget(DepDrop::classname(), [
                                'type' => 2,
                                'data'=>$paciente_model->isNewRecord ? '' : [$paciente_model->ideps => $paciente_model->ideps0->nombre],
                                // 'options'=>['id'=>'eps_id'],
                                'pluginOptions'=>[
                                'depends'=>['ips_id'],
                                'placeholder'=>'Seleccione EPS',
                                'url'=>Url::to(['/procedimientos/subafiliacion'])
                            ]
                        ])->label('Afiliación');  
                    ?>

                    <?= $form->field($paciente_model, 'telefono')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->telefono, 'maxlength' => 15]) ?>
                    
                    <?= $form->field($paciente_model, 'email')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->email, 'maxlength' => 100]) ?>
                    
        <!-- --> <?= $form->field($paciente_model, 'codeps')->textInput()->label('Edad') ?> <!-- Campo usado para la edad -->

                    <?= $form->field($paciente_model, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->isNewRecord ? '' : $model->idpacientes0->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
                    
                    <?= $form->field($paciente_model, 'envia_email')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Enviar email') ?>
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
                
                    <?= $form->field($model, 'valor_procedimiento')->textInput(['class'=>'form-control saldo']) ?>

                    <?= $form->field($model, 'descuento')->textInput(['readOnly'=>'']) ?>
                
                    <?= $form->field($model, 'valor_copago')->textInput() ?>
                
                    <?= $form->field($model, 'valor_abono')->textInput(['class'=>'form-control saldo']) ?>

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
                
                <div id="panelAddMedico" class="col-sm-12">
                    <div class="col-sm-12">
                        <label class="control-label" for="medrem">Médicos remitentes</label>
                    </div>
                    <div class="col-sm-10">
                        <?php if($model->isNewRecord){ ?>
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
                        <?php } ?>
                    </div>   
                    <div class="col-sm-2"><a href="" id="agregar" onclick="cerrarModal(medRemNuevo)" class="btn btn-default">Añadir</a></div>
                </div>
                <div class="col-sm-12" style="padding: 10px 30px;">
                    <?= Html::input('checkBox','nombre','',['id'=>'showHidePanel', 'class'=>'']);?>
                    <label for="showHidePanel">Agregar un médico nuevo</label>
                </div>


                <div class="panel panel-default">
                    <div class="panelFormulario-contenido">
                        <div id="panelMedico"  class="panel-body">
                            <?php if($model->isNewRecord){ ?>
                                <?=$this->render('//medicos-remitentes/_form', [
                                    'model'=>$medicoRemModel,
                                    'lista_especialidades'=>$lista_especialidades,
                                    'ips_model'=>$ips_model,
                                    'ips_list'=>$ips_list,
                                ]);?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
    $js = <<<SCRIPT

$('form#procForm').on('beforeSubmit', function(e)
{
    var \$form = $(this);

    $.post(
        \$form.attr("action"), 
        \$form.serialize()
    )
    .done(function(result) {
        if(result == 0)
        {
            notification('Error: No se pudieron guardar los cambios', 2);
        }else{
            $('.modal').modal('hide');
            notification('Se guardaron los cambios correctamente', 1);
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