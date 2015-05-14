<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = $model->nombre1. ' ' . $model->nombre2. ' ' . $model->apellido1. ' ' . $model->apellido2;
// $this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="pacientes-update">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'lista_tipos'=>$lista_tipos,
        'lista_tipoid'=>$lista_tipoid,
        'lista_resid'=>$lista_resid,
        'lista_ciudades'=>$lista_ciudades,
        'lista_eps'=>$lista_eps,
        'id_cliente'=>$id_cliente,
    ]) ?>

</div>
