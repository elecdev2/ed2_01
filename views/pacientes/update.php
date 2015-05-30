<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = $model->nombre1. ' ' . $model->nombre2. ' ' . $model->apellido1. ' ' . $model->apellido2;
// $this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="pacientes-update">
<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_tipos'=>$lista_tipos,
		        'lista_tipoid'=>$lista_tipoid,
		        'lista_resid'=>$lista_resid,
		        'lista_ciudades'=>$lista_ciudades,
		        'lista_eps'=>$lista_eps,
		        'id_cliente'=>$id_cliente,
		    ]) ?>
		</div>
	</div>

</div>
