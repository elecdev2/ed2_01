<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-9">
                <h2 class="titulo"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-3">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['usuarios/update?id='.$model->id]),
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
                'attribute'=>'idmedicos',
                'label'=>'Es usuario médico?',
                'value'=>$model->idmedicos == null ? 'No' : 'Si',
            ],
            // 'idmedicos',
            // 'password',
            'nombre',
            // 'idclientes',
            'username',
            [
                'attribute'=>'activo',
                'value'=>$model->activo == 1 ? 'Si' : 'No',
            ],
            // 'activo',
        ],
    ]) ?>

</div>
