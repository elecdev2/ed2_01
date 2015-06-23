<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\ListasSistema;
use app\models\Ciudades;

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
            [
                'attribute'=>'tipo_usuario',
                'label'=>'Tipo de usuario',
                'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$model->tipo_usuario])->scalar(),
            ],
            [
                'attribute'=>'tipo_residencia',
                'label'=>'Tipo de residencia',
                'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$model->tipo_residencia])->scalar(),
            ],
            // 'idclientes',
            [
                'attribute'=>'activo',
                'value'=>$model->activo = 1 ? 'Si' : 'No',
            ],
            [
                'attribute'=>'idciudad',
                'label'=>'Ciudad',
                'value'=>Ciudades::findOne($model->idciudad)->nombre,
            ],
            
            [
                'attribute'=>'ideps',
                'label'=>'EPS',
                'value'=>$model->ideps != null ? $model->ideps0->nombre : '',
            ],
            [
                'attribute'=>'email',
                'label'=>'Email',
                'value'=>$model->email,
            ],
            [
                'attribute'=>'envia_email',
                'label'=>'Enviar email',
                'value'=>$model->email = 1 ? 'Si' : 'No',
            ],
            'codeps',
        ],
    ]) ?>

</div>
