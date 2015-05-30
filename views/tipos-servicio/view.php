<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Ips;

/* @var $this yii\web\View */
/* @var $model app\models\TiposServicio */
$ips = Ips::find()->select(['nombre'])->where(['id'=>$model->idips])->scalar();
$this->title = $model->nombre.' - '.$ips;
// $this->params['breadcrumbs'][] = ['label' => 'Tipos Servicios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-servicio-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nombre',
            [
                'attribute'=>'idips',
                'value'=>$ips,
            ],            
            'consecutivo',
            'serie',
        ],
    ]) ?>

</div>
