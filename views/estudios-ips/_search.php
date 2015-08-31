<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\EstudiosIpsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudios-ips-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'cod_cups', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>$lista_est,
            'language' => 'es',
            'options' => ['placeholder' => 'Estudio'],
            'pluginOptions' => [
                'allowClear' => true
                ],
            ]);
        ?>
    </div>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'idtipo_servicio', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
            'data'=>$lista_tipos,
            'language' => 'es',
            'options' => ['placeholder' => 'Tipos de estudio'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    </div>

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
