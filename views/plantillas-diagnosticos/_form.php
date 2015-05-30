<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use app\models\Usuarios;

/* @var $this yii\web\View */
/* @var $model app\models\PlantillasDiagnosticos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plantillas-diagnosticos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'plantForm', 'validateOnType' => true, 'options'=>['enctype' => 'multipart/form-data', 'onsubmit'=>'submitForm']]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textArea(['style'=>'width:100%', 'rows'=>'7', 'cols'=>'50', 'maxlength' => true]) ?>

    <?= $form->field($model, 'id_medico')->hiddenInput(['value'=>$model->isNewRecord ? Usuarios::findOne(Yii::$app->user->id)->idmedicos : $model->id_medico])->label('') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
