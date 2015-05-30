<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            // 'nombre',
            'direccion',
            'tipo_identificacion',
            'nit',
            'telefono',
            [
                'attribute'=>'idclientes',
                'value'=>$model->idclientes0->nombre,
            ],
            [
                'attribute'=>'activo',
                'value'=>$model->activo == 1 ? 'Si' : 'No',
            ],
            
            'consecutivo_fact',
            'representante_legal',
            'consecutivo_recibo',
            'descripcion',
            'mensaje_email:email',
        ],
    ]) ?>

</div>
