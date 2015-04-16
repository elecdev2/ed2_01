<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = $model->nombre1.' '.$model->nombre2.' '.$model->apellido1.' '.$model->apellido2;
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-view">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-9">
                <h2 class="titulo"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-3">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['pacientes/update?id='.$model->id]),
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
            'tipo_identificacion',
            'identificacion',
            // 'apellido1',
            // 'nombre1',
            // 'nombre2',
            // 'apellido2',
            'direccion',
            'telefono',
            'sexo',
            'fecha_nacimiento',
            'tipo_usuario',
            'tipo_residencia',
            // 'idclientes',
            'activo',
            'idciudad',
            // [
            //     'attribute'=>'ideps',
            //     'value'=>$model->ideps0->nombre,
            // ],
            'ideps',
            'email:email',
            'envia_email:email',
            'codeps',
        ],
    ]) ?>

</div>
