<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-view">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['medicos/update?id='.$model->id]),
                    'id' => 'actualizar',
                    'class'=>'btn btn-primary btn-lg',
                    'style'=>'float:right',
         
                ]) ?>
                <!-- <button id="actualizar" class="btn btn-primary btn-lg"></button> -->
            </div>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ips_idips',
            'idespecialidades',
            'codigo',
            'nombre',
            // 'id',
            // 'idclientes',
            // 'ruta_firma',
        ],
    ]) ?>

</div>
