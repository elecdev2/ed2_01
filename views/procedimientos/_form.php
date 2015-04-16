<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use app\models\Ips;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'procForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>
        
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="form-group">
                <label class="control-label col-sm-3">N° de identificación *</label>
                <div class="col-sm-6">                
                    <input id="documento" type="number" required class="form-control" value="<?= $model->isNewRecord ? '' : $model->idpacientes0->identificacion?>">
                </div>
            </div>

            <div class="row text-center">
                <h4 id="pacienteName"><?=$model->isNewRecord ? '' :$model->idpacientes0->nombre1.' '.$model->idpacientes0->nombre2.' '.$model->idpacientes0->apellido1.' '.$model->idpacientes0->apellido2 ?> 
                  
                <?php if(!$model->isNewRecord){ ?>
                    <h5 id="edad">Edad: <?= $model->idpacientes0->fecha_nacimiento !== '0000-00-00' ? date_diff(date_create($model->idpacientes0->fecha_nacimiento), date_create(date('Y-m-d')))->y : 'N/A' ?></h5>
                <?php } ?>
            </div>

                <?= $form->field($model, 'idpacientes')->hiddenInput()->label('') ?>

                <?= $form->field($paciente_model, 'direccion')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->direccion, 'maxlength' => 100]) ?>

                <?= $form->field($paciente_model, 'telefono')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->telefono, 'maxlength' => 15]) ?>
                
                <?= $form->field($paciente_model, 'email')->textInput(['value'=>$model->isNewRecord ? '' : $model->idpacientes0->email, 'maxlength' => 100]) ?>

                <?= $form->field($paciente_model, 'fecha_nacimiento')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->isNewRecord ? '' : $model->idpacientes0->fecha_nacimiento, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
        </div>
    </div>
        
            <input type="text" name="url" id="url" hidden>  
        
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
        
        
            <?= $form->field($model, 'medico')->textInput(['maxlength' => 150]) ?>
        
        
        
            <?= $form->field($model, 'observaciones')->textArea(['maxlength' => 200]) ?>
        

            <?= $form->field($model, 'forma_pago')->widget(Select2::classname(), [
                    'data'=>array_merge(["" => ""], $lista_pago),
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione una forma de pago'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Forma de pago');
            ?>

        
        
         

        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>'btn btn-success']) ?>
        </div>
    


    <?php ActiveForm::end(); ?>

</div>

<div id="pacienteModal" class="modal fade bs-example-modal-sm" data-backdrop="true" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar paciente</h4>
            </div>
            <div class="modal-body">
                <?php if($model->isNewRecord){ ?>
                   <?= $this->render('//pacientes/_form', [
                        'model' => $paciente_model,
                        'lista_tipos'=>$lista_tipos,
                        'lista_tipoid'=>$lista_tipoid,
                        'lista_resid'=>$lista_resid,
                        'lista_ciudades'=>$lista_ciudades,
                        'lista_eps'=>$lista_eps,
                        'id_cliente'=>$id_cliente,
                    ]) ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <div></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#url').val(getUrlVars());

        $('#procedimientos-cod_cups').on('change', function(event) {
            var cod_cup = $(this).val();
            var eps_id = $('#eps_id').val();
            if(cod_cup != ''){
                $.post('precio', {cod: cod_cup, id: eps_id}, function(data) {
                    $('#procedimientos-valor_procedimiento').val(data['valor_procedimiento']);
                    $('#procedimientos-valor_saldo').val(data['valor_procedimiento']);
                    $('#procedimientos-descuento').val(data['descuento']);
                    // console.log(data['valor_procedimiento']);
                });
            }
        });

        $('#procedimientos-valor_abono').on('change', function(event) {
            event.preventDefault();
            var abono = parseFloat($('#procedimientos-valor_abono').val());
            var saldo = parseFloat($('#procedimientos-valor_saldo').val());
            

            if(isNaN(abono)){
                $('#procedimientos-valor_saldo').val(saldo);
            }else{
                $('#procedimientos-valor_saldo').val(saldo-abono);
            }
        });
    });
</script>