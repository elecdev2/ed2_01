<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Informes */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nombre',
        ],
    ]) ?>

</div>
