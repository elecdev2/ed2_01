<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'ips_idips',
                'label'=>'IPS',
                'value'=> $model->ipsIdips->nombre,
            ],
            // 'ips_idips',
            [
                'attribute'=>'idespecialidades',
                'label'=> 'Especialidad',
                'value'=> $model->idespecialidades0->nombre,
            ],
            // 'idespecialidades',
            'codigo',
            // 'nombre',
            // 'id',
            // 'idclientes',
            // 'ruta_firma',
            [
                'attribute'=>'ruta_firma',
                'label'=>'Firma',
                'value'=>$model->ruta_firma != null ? Html::img(Yii::$app->request->baseUrl.'/images/firmas/'.$model->ruta_firma, ['width'=>'200px', 'alt'=>'Firma médico', 'class'=>'responsive']) : 'No definida',
                'format' => 'raw',
                // 'format' => ['image',['width'=>'100','height'=>'100']],
            ]
        ],
    ]) ?>

</div>
