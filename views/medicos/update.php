<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicos-update">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'lista_especialidades'=>$lista_especialidades,
        'lista_ips'=>$lista_ips,
    ]) ?>

</div>
