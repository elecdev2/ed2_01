<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\ListasSistema;

// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Campos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campos-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

  

    <?= $form->field($client_model, 'id')->dropDownList($list_client, ['prompt'=>'Seleccione una opción', 'id'=>'client_id'])->label('Cliente');?>

    <?= $form->field($ips_model, 'id')->widget(DepDrop::classname(), [
             'options'=>['id'=>'ips_id'],
             'type' => 2,
             'pluginOptions'=>[
                 'depends'=>['client_id'],
                 'placeholder' => 'Seleccione una IPS',
                 'url' => Url::to(['/tipos-servicio/subnombre'])
             ]
        ])->label('IPS');
    ?>
    
    <?= $form->field($model, 'idtipos_servicio')->widget(DepDrop::classname(), [
                'type' => 2,
                'data'=>$model->isNewRecord ? '' : [$model->idtipos_servicio => $model->idtiposServicio->nombre],
                'pluginOptions'=>[
                'depends'=>['client_id', 'ips_id'],
                'placeholder'=>'Seleccione tipo de estudio',
                'url'=>Url::to(['/campos/subtipo'])
            ]
        ])->label('Tipo de servicio');  
    ?>

    <!-- <?= $form->field($model, 'idtipos_servicio')->textInput() ?> -->

    <?= $form->field($model, 'tipo_campo')->widget(Select2::classname(), [
            'data' => $tipo_campos,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un tipo de campo'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Tipo de campo');
    ?>

    <!-- <?= $form->field($model, 'tipo_campo')->textInput(['maxlength' => 45]) ?> -->

    <?= $form->field($model, 'titulos_idtitulos')->widget(Select2::classname(), [
            'data' => $titulos_list,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un titulo'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Titulo');
    ?>

    <!-- <?= $form->field($model, 'titulos_idtitulos')->textInput() ?> -->

    <?= $form->field($model, 'nombre_campo')->textInput(['maxlength' => 200])->label('Nombre de campo') ?>

    <!-- <?= $form->field($model, 'orden')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['campos/index'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
