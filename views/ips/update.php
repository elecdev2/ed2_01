<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = 'Actualizar Ips: ' . ' ' . $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="ips-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_client'=>$list_clientes,
        'listdata'=>$listdata,
    ]) ?>

</div>
