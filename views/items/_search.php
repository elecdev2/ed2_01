<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'validateOnType' => true,
    ]); ?>

    <div class="col-sm-6 col-lg-12">
        <?= $form->field($model, 'description', ['template'=>"{input}{error}"])->textInput(['placeholder'=>'Perfil']); ?>
    </div>

    <!-- <?//echo $form->field($model, 'type') ?> -->

    <!-- <?//echo $form->field($model, 'name') ?> -->

    <!-- <?//echo $form->field($model, 'rule_name') ?> -->

    <!-- <?//echo $form->field($model, 'data') ?> -->

    <!-- <?php // echo $form->field($model, 'created_at') ?> -->

    <!-- <?php // echo $form->field($model, 'updated_at') ?> -->

    <div class="col-sm-12 form-group  botones-search">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
