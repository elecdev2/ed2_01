<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlantillasDiagnosticos */

$this->title = $model->titulo;
// $this->params['breadcrumbs'][] = ['label' => 'Plantillas Diagnosticos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="plantillas-diagnosticos-update">
    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
     <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>


</div>
