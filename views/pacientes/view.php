<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = $model->nombre1.' '.$model->nombre2.' '.$model->apellido1.' '.$model->apellido2;
// $this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
   
    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
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
