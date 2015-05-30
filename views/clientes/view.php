<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'nombre',
            [
                'attribute'=>'activo',
                'value'=>$model->activo == 1 ? 'Si' : 'No',
            ],            
            // 'tema',
            'tipo_consecutivo',
        ],
    ]) ?>

</div>
