<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Eps */

$this->title =  $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Eps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="eps-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lista_ips'=>$lista_ips,
        'id_cliente'=>$id_cliente,
        'lista_informes'=>$lista_informes,
    ]) ?>

</div>
