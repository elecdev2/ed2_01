<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    
    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'pacForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <input type="text" name="url" id="url" hidden>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Nombre del perfil') ?>

    <div class="form-group field-tipod_estudios required">
        <label class="control-label col-sm-3" for="tipos_estudios">Perfiles</label>
        <div class="col-sm-6">
            <?= Select2::widget([
                'data'=>$lista_perfiles,
                'language' => 'es',
                'name'=>'perf',
                'options' => ['placeholder' => 'Seleccione los perfiles', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);  ?>
        </div>
    </div>

    <!-- <?//echo $form->field($model, 'type')->textInput() ?> -->

    <!-- <?//echo $form->field($model, 'name')->textarea(['rows' => 6]) ?> -->

    <!-- <?//echo $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?> -->

    <!-- <?//echo $form->field($model, 'data')->textarea(['rows' => 6]) ?> -->

    <!-- <?//echo $form->field($model, 'created_at')->textInput() ?> -->

    <!-- <?//echo $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
