<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recibos */

$this->title = 'Update Recibos: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recibos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recibos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
