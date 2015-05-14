<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Informes */

$this->title = 'Actualizar Informes: ' . ' ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="informes-update">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
