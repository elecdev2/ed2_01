<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->description;
// $this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->name?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_perfiles'=>$lista_perfiles,
		    ]) ?>
		</div>
	</div>

</div>
