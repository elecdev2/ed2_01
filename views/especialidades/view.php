<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Especialidades */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Especialidades', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="especialidades-view">

   <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            'nombre',
        ],
    ]) ?>

</div>
