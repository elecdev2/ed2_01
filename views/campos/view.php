<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Campos */

$this->title = $model->nombre_campo;
// $this->params['breadcrumbs'][] = ['label' => 'Campos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="campos-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute'=>'idtipos_servicio',
                'value'=>$model->idtiposServicio->nombre,
            ],
            
            'tipo_campo',
            'nombre_campo',
            'titulos_idtitulos',
            'orden',
        ],
    ]) ?>

</div>
