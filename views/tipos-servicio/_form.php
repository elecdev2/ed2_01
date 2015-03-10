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

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($client_model, 'id')->widget(Select2::classname(), [
            'data' => array_merge(["" => ""], $list_client),
            'language' => 'es',
            'options' => ['id'=>'client_id', 'placeholder' => 'Seleccione un cliente'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Cliente'); 
    ?>

    <!-- <?= $form->field($client_model, 'id')->dropDownList($list_client, ['prompt'=>'Seleccione una opción', 'id'=>'id']);?>  -->

    <?= $form->field($model, 'nombre')->widget(DepDrop::classname(), [
		     'pluginOptions'=>[
		         'depends'=>['client_id'], //USAR EL METODO PARA OBTENER EL ID
		         'placeholder' => 'Select...',
		         'url' => Url::to(['/tipos-servicio/subnombre'])
		     ]
 		]);
 	?>

    <!-- <?= $form->field($model, 'nombre')->textInput(['maxlength' => 100]) ?> -->

    <?= $form->field($model, 'idips')->textInput() ?>

    <?= $form->field($model, 'consecutivo')->textInput() ?>

    <?= $form->field($model, 'serie')->textInput(['maxlength' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
