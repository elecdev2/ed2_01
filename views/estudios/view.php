<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */

$this->title = $model->cod_cups;
// $this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudios-view">

     <input type="text" hidden name="id_help" data-value="<?=$model->cod_cups?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cod_cups',
            'descripcion',
        ],
    ]) ?>

</div>
