<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProcedimientosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <!-- <?= $form->field($model, 'id') ?> -->
    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'numid_paciente', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'CC Paciente']); ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'fecha_atencion', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha de atención"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'autorizacion', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Autorización']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'numero_muestra', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Número de muestra']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'valor_procedimiento', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Costo del procedimiento']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?= $form->field($model, 'estado', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>array_merge(["" => ""], $lista_estados),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un estado'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    </div>
    
    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'eps_ideps', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'cod_cups', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código del procedimiento']) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'cantidad_muestras', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'valor_copago', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'valor_saldo', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'valor_abono', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'medico', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'observaciones', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'forma_pago', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'numero_cheque', ['template'=>"{input}{error}"]) ?>
    </div>


    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'fecha_informe', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'numero_factura', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'fecha_salida', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'fecha_entrega', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'periodo_facturacion', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'idtipo_servicio', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'idmedico', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'usuario_recibe', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'usuario_transcribe', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'descuento', ['template'=>"{input}{error}"]) ?>
    </div>

    <div class="col-sm-6 col-lg-4">
        <?php // echo $form->field($model, 'idbackup', ['template'=>"{input}{error}"]) ?>
    </div>


    <div class="col-sm-12 form-group text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
