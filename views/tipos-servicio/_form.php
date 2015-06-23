<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\TiposServicio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-servicio-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'tsForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <input type="text" name="url" id="url" hidden>

    <?= $form->field($client_model, 'id')->dropDownList($list_client, ['prompt'=>'Seleccione una opción', 'id'=>'client_id'])->label('Cliente');?>

    <?= $form->field($model, 'idips')->widget(DepDrop::classname(), [
            'type'=>2,
		     'pluginOptions'=>[
		         'depends'=>['client_id'],
		         'placeholder' => 'Seleccione una IPS',
		         'url' => Url::to(['/tipos-servicio/subnombre'])
		     ]
 		])->label('IPS');
 	?>

    <!-- <?= $form->field($model, 'idips')->textInput() ?> -->
    
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'consecutivo')->textInput() ?>

    <?= $form->field($model, 'serie')->textInput(['maxlength' => 1]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
