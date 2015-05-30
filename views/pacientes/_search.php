<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\PacientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pacientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>


    <?php // echo $form->field($model, 'id', ['template'=>"{input}{error}"]) ?>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'tipo_identificacion', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>$lista_tipoid,
            'language' => 'es',
            'options' => ['placeholder' => 'Tipo de ID'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'identificacion', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Identificación']); ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nombre1', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Primer nombre']); ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'nombre2', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Segundo nombre']); ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'apellido1', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Primer apellido']); ?>
</div>

<div class="col-sm-6 col-lg-4">
    <?= $form->field($model, 'apellido2', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Segundo apellido']); ?>
</div>

    <?php // echo $form->field($model, 'direccion', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'telefono', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'sexo', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'fecha_nacimiento', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'tipo_usuario', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'tipo_residencia', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'idclientes', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'activo', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'idciudad', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'ideps', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'email', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'envia_email', ['template'=>"{input}{error}"]) ?>

    <?php // echo $form->field($model, 'codeps', ['template'=>"{input}{error}"]) ?>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
