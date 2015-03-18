<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Actualizar procedimiento: ' . ' ' . $model->numero_muestra;
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="procedimientos-update text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model,
        'paciente_model'=>$paciente_model,
        'ips_model'=>$ips_model,
        'ips_list'=>$ips_list,
    ]) ?>

</div>
