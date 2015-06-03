<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->description;
// $this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

    <input type="text" hidden name="id_help" data-value="<?=$model->name?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'name',
                'label'=>'Nombre',
            ],
            // 'type',
            'description:ntext',
            // 'rule_name',
            // 'data:ntext',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
