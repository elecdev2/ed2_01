<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estudios */

$this->title = $model->cod_cups;
// $this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->cod_cups, 'url' => ['view', 'id' => $model->cod_cups]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="estudios-update">

    <input type="text" hidden name="id_help" data-value="<?=$model->cod_cups?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>

</div>
