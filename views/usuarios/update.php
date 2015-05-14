<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuarios-update">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'id_cliente'=>$id_cliente,
        'lista_perf'=>$lista_perf,
        'modelMedico'=>$modelMedico,
        'lista_ips'=>$lista_ips,
        'lista_especialidades'=>$lista_especialidades,
    ]) ?>

</div>
