<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TiposServicio */

$this->title = 'Actualizar';
// $this->params['breadcrumbs'][] = ['label' => 'Tipos Servicios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipos-servicio-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'client_model'=>$client_model,
		        'list_client'=>$list_client,
		    ]) ?>
		</div>
	</div>
</div>
