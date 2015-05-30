<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PlantillasDiagnosticos */

$this->title = $model->titulo;
// $this->params['breadcrumbs'][] = ['label' => 'Plantillas Diagnosticos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantillas-diagnosticos-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'titulo',
            'descripcion',
            // 'id_medico',
        ],
    ]) ?>

</div>
