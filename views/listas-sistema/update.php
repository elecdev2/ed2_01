<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ListasSistema */

$this->title = 'Update Listas Sistema: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Listas Sistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="listas-sistema-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
