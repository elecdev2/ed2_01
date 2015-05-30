<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = $model->idestudios0->descripcion;
// $this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarifas-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute'=>'eps_id',
                'label'=>'EPS',
                'value'=>$model->eps->nombre,
            ],
            [
                'attribute'=>'idestudios',
                'label'=>'Estudio',
                'value'=>$model->idestudios0->descripcion,
            ],
            [
                'attribute'=>'valor_procedimiento',
                'label'=>'valor del estudio',
                'value'=>'$'.number_format($model->valor_procedimiento),
            ],
            [
                'attribute'=>'descuento',
                'value'=>number_format($model->descuento).'%',
            ],
            
        ],
    ]) ?>

</div>
