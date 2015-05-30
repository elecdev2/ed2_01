<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="ips-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
	
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'list_client'=>$list_clientes,
		        'listdata'=>$listdata,
		    ]) ?>
		</div>
	</div>

</div>
