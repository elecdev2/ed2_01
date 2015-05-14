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

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['medicos/update?id='.$model->id]),
                    'class'=>'update upd updModal',
                    'style'=>'float:right',
         
                ]) ?>
                <!-- <button id="actualizar" class="btn btn-primary btn-lg"></button> -->
            </div>

        </div>
    </div>


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
