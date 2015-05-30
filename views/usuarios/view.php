<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre.' - '.$model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

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
