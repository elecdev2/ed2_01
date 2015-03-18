<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use app\models\Ips;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'procForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>
        <div class="form-group">
            <label class="control-label col-sm-3">N° de identificación *</label>
            <div class="col-sm-6">                
                <input id="documento" type="number" required class="form-control" value="<?= $model->isNewRecord ? '' : $model->idpacientes0->identificacion?>">
            </div>
        </div>

        <div class="row text-center">
            <h4 id="pacienteName"><?=$model->isNewRecord ? '' :$model->idpacientes0->nombre1.' '.$model->idpacientes0->nombre2.' '.$model->idpacientes0->apellido1.' '.$model->idpacientes0->apellido2 ?></h4>
        </div>

            <input type="text" name="url" id="url" hidden>
            <?= $form->field($model, 'idpacientes')->hiddenInput()->label('') ?>
        
        
            <?= $form->field($model, 'fecha_atencion')->widget(yii\jui\DatePicker::classname(), ["id" => "pacientes-fecha_atencion", "name" => "Pacientes[fecha_atencion]", "dateFormat" => "yyyy-MM-dd", 'options' => ['value'=>$model->fecha_atencion, 'class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
        
        

                
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
        
        

        
            <?= $form->field($model, 'numero_muestra')->textInput(['maxlength' => 15]) ?>
        
        

       
            <?= $form->field($model, 'valor_procedimiento')->textInput() ?>
        
        

        
            <?= $form->field($model, 'cantidad_muestras')->textInput() ?>
        
        

        
            <?= $form->field($model, 'valor_copago')->textInput() ?>
        
        

        
            <?= $form->field($model, 'valor_saldo')->textInput() ?>
        
        

        
            <?= $form->field($model, 'valor_abono')->textInput() ?>
        
        

        
            <?= $form->field($model, 'medico')->textInput(['maxlength' => 150]) ?>
        
        

        
            <?= $form->field($model, 'observaciones')->textInput(['maxlength' => 200]) ?>
        
        

        
           <?= $form->field($model, 'forma_pago')->textInput(['maxlength' => 3]) ?>
       
        

        
            <?= $form->field($model, 'numero_cheque')->textInput(['maxlength' => 15]) ?>
        
        

        
            <?= $form->field($model, 'estado')->textInput(['maxlength' => 3]) ?>
        
        

        
            <?= $form->field($model, 'fecha_informe')->textInput() ?>
        
        

        
            <?= $form->field($model, 'numero_factura')->textInput(['maxlength' => 15]) ?>
        
        

        
            <?= $form->field($model, 'fecha_salida')->textInput() ?>
        
        

        
            <?= $form->field($model, 'fecha_entrega')->textInput() ?>
        
        

        
            <?= $form->field($model, 'periodo_facturacion')->textInput() ?>
        
        

        
            <?= $form->field($model, 'idmedico')->textInput() ?>
        
        
            
            <?= $form->field($model, 'usuario_recibe')->textInput() ?>
        
        

        
            <?= $form->field($model, 'usuario_transcribe')->textInput() ?>
        
        

        
            <?= $form->field($model, 'descuento')->textInput() ?>
        
         

        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                    ]) ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button id="reg_pac" type="button" class="btn btn-primary" >Registrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#url').val(getUrlVars());
    });
</script>