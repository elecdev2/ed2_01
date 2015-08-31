<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EpsTipos */

$this->title = 'Update Eps Tipos: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Eps Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eps-tipos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
