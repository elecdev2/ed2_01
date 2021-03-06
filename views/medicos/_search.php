<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MedicosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <?php // $form->field($model, 'ips_idips') ?>


<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'idespecialidades', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>$lista_especialidades,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una especialidad'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'codigo', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Código']) ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre']) ?>
</div>

    <?php //$form->field($model, 'id', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Autorización']) ?>

    <?php // $form->field($model, 'idclientes', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Autorización']) ?>

    <?php // $form->field($model, 'ruta_firma', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Autorización']) ?>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
