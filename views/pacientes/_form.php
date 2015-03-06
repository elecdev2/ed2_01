<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pacientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_identificacion')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'apellido1')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'nombre1')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'nombre2')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'apellido2')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'sexo')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

    <?= $form->field($model, 'tipo_usuario')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'tipo_residencia')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'idclientes')->textInput() ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <?= $form->field($model, 'idciudad')->textInput() ?>

    <?= $form->field($model, 'ideps')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'envia_email')->textInput() ?>

    <?= $form->field($model, 'codeps')->textInput(['maxlength' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
