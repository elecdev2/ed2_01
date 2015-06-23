<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ips-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'ipsForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <input type="text" name="url" id="url" hidden>

    <?= $form->field($model, 'idclientes')->widget(Select2::classname(), [
            'data' => array_merge(["" => ""], $list_client),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un cliente'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Cliente *'); 
    ?>

    <!-- <?= $form->field($model, 'idclientes')->dropDownList($list_client,['prompt'=>'Seleccione una opción'])->label('Cliente *');?> -->
    <!-- <?= $form->field($model, 'idclientes')->textInput() ?> -->

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15])->label('Código *') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150])->label('Ips *') ?>

    <?= $form->field($model, 'descripcion')->textArea(['maxlength' => 100]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 100])->label('Dirección *') ?>
    
    <?= $form->field($model, 'tipo_identificacion')->dropDownList($listdata,['prompt'=>'Seleccione una opción'])->label('Tipo ID *');?>

    <!-- <?= $form->field($model, 'tipo_identificacion')->textInput(['maxlength' => 3]) ?> -->

    <?= $form->field($model, 'nit')->textInput(['maxlength' => 15])->label('Nit *') ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 30])->label('Teléfono *') ?>

    <?= $form->field($model, 'consecutivo_fact')->textInput()->label('Consecutivo de factura *') ?>
    
    <?= $form->field($model, 'consecutivo_recibo')->textInput()->label('Consecutivo de recibo *') ?>

    <?= $form->field($model, 'representante_legal')->textInput(['maxlength' => 100])->label('Representante legal *') ?>
    
    <?= $form->field($model, 'mensaje_email')->textArea(['cols'=>'50','rows'=>'8','maxlength' => 1000])->label('Mensaje email *') ?>

    <div class="text-center">
        <a href="" class="btn btn-azul" id="convencion" >Convención</a>
    </div>
    
    <?= $form->field($model, 'mensaje_med')->textArea(['cols'=>'50','rows'=>'8', 'maxlength' => 1000])->label('Mensaje email médico *') ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 200])->label('URL *') ?>

    <?= $form->field($model, 'activo')->dropDownList(['prompt'=>'Seleccione una opción', '1' => 'Si', '2' => 'No'])->label('Activo *') ?>
    <!-- <?= $form->field($model, 'activo')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="convModal" class="modal fade bs-example-modal-md" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" onclick="cerrarModal(convModal)"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="titulo-tarifa">Convención</h3>
            </div>
            <div class="modal-body">
                 <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label'=>'nombre1Pac',
                            'value'=>'primer nombre del paciente',
                        ],
                        [
                            'label'=>'nombre2Pac',
                            'value'=>'segundo nombre del paciente',
                        ],
                        [
                            'label'=>'apellido1Pac',
                            'value'=>'primer apellido del paciente',
                        ],
                        [
                            'label'=>'nombre1Pac',
                            'value'=>'primer nombre del paciente',
                        ],
                        [
                            'label'=>'apellido2Pac',
                            'value'=>'segundo apellido del paciente',
                        ],
                        [
                            'label'=>'identificacion',
                            'value'=>'ID del paciente',
                        ],
                        [
                            'label'=>'ips',
                            'value'=>'Nombre de la IPS',
                        ],
                        [
                            'label'=>'codEst',
                            'value'=>'codigo del estudio',
                        ],
                        [
                            'label'=>'nombreMedRe',
                            'value'=>'Nombre del medico remitente',
                        ],
                        [
                            'label'=>'nombreMedTr',
                            'value'=>'Nombre del medico tratante',
                        ],
                        [
                            'label'=>'nombreEst',
                            'value'=>'nombre del estudio',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
