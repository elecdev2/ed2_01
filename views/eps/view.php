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

     <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-9">
                <h2 class="titulo"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-3">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['eps/update?id='.$model->id]),
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
