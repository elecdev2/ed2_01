<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MedicosRemitentes */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Medicos Remitentes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-remitentes-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            'nombre',
            'telefono',
            'email:email',
            [
                'attribute'=>'especialidades_id',
                'label'=>'Especialidad',
                'value'=>$model->especialidades->nombre,
            ],
            
        ],
    ]) ?>

</div>
