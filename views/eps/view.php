<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Eps */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Eps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-view">

   <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute'=>'idips',
                'value'=>  $model->idips0->nombre,
            ],
            // 'idips',
            'codigo',
            'nombre',
            'direccion',
            'telefono',
            'nit',
            [
                'attribute'=>'generar_rip',
                'value'=> $model->generar_rip == 1 ? 'Si' : 'No',
            ],
            // 'generar_rip',
            [
                'attribute'=>'idinformes',
                'value'=>  $model->idinformes0->nombre,
            ],
            // 'idinformes',
            [
                'attribute'=>'activo',
                'value'=> $model->activo == 1 ? 'Si' : 'No',
            ],
            // 'activo',
        ],
    ]) ?>

</div>
