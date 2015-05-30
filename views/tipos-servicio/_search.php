<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TiposServicioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-servicio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'nombre', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Nombre'])->label('') ?>
    </div>

    <div class="col-sm-6 col-lg-6">
        <?= $form->field($model, 'idips', ['template'=>"{input}{error}"])->dropDownList(ArrayHelper::map($ips_list,'id','nombre'), ['prompt'=>'IPS'])->label('');?>
    </div>

    <!-- <?//echo $form->field($model, 'consecutivo') ?> -->

    <!-- <?//echo $form->field($model, 'serie') ?> -->

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
