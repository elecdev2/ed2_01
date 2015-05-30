<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Eps */

$this->title =  $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Eps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="eps-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
                'lista_ips'=>$lista_ips,
                'id_cliente'=>$id_cliente,
                'lista_informes'=>$lista_informes,
            ]) ?>
        </div>
    </div>


</div>
