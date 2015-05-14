<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */

$this->title = 'Actualizar Estudios: ' . ' ' . $model->cod_cups;
// $this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->cod_cups, 'url' => ['view', 'id' => $model->cod_cups]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="estudios-update">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
