<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\HistoriaClinicaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historia-clinica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-sm-5 col-lg-4">
        <?= $form->field($model, 'paciente', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'ID paciente'])->label('') ?>
    </div>
    <div class="col-sm-5 col-lg-4">
        <?= $form->field($model, 'fecha', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['id'=>'fecha_hist', 'class' => 'fecha form-control', "placeholder" => "Fecha"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
    </div>
    <!-- <div class="col-sm-5 col-lg-4">
        <?= $form->field($model, 'hora', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Hora'])->label('') ?>
    </div> -->

    <div class="col-sm-5 col-lg-4">
        <?= $form->field($model, 'diag', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
                        'language' => 'es',
                        'options' => [
                            'placeholder' => 'Seleccione un diagnostico',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Seleccione un diagnostico',
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => 'cod-diag',
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(cod) { return cod.text; }'),
                            'templateSelection' => new JsExpression('function (cod) { return cod.text; }'),
                        ],
                    ])->label('');
                ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
