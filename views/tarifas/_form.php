<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarifas-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'tarifasForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <?= $form->field($model, 'eps_id')->hiddenInput(['value'=>$model->isNewRecord ? $ideps : $model->eps_id])->label('') ?>

    <?= $form->field($model, 'idestudios')->widget(Select2::classname(), [
            'data'=>$lista_estudios,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un estudio'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Estudio');
    ?>

    <!-- <?= $form->field($model, 'idestudios')->textInput(['maxlength' => 20]) ?> -->

    <?= $form->field($model, 'valor_procedimiento')->textInput() ?>

    <?= $form->field($model, 'descuento')->textInput() ?>

    <input type="text" hidden name="ideps" value="<?=$ideps?>">

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
