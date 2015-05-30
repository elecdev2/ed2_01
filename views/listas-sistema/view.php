<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ListasSistema */

$this->title = $model->descripcion;
// $this->params['breadcrumbs'][] = ['label' => 'Listas Sistemas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="listas-sistema-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            'descripcion',
            'tipo',
        ],
    ]) ?>

</div>
