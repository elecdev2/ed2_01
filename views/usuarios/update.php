<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuarios-update">
<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
                'id_cliente'=>$id_cliente,
                'lista_perf'=>$lista_perf,
                'modelMedico'=>$modelMedico,
                'lista_ips'=>$lista_ips,
                'lista_especialidades'=>$lista_especialidades,
            ]) ?>
        </div>
    </div>
</div>
