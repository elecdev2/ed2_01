<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Campos */

$this->title = $model->nombre_campo;
// $this->params['breadcrumbs'][] = ['label' => 'Campos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="campos-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
                'list_client'=>$list_client, 
                'client_model'=>$client_model,
                'ips_model' => $ips_model,
                'titulos_model'=>$titulos_model,
                'titulos_list'=>$titulos_list,
                'tipo_campos'=>$tipo_campos,
            ]) ?>
        </div>
    </div>

</div>
