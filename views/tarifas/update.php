<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

// $this->title = $model->eps->nombre.' - estudio: '.$model->idestudios;
$this->title = $model->idestudios0->descripcion;
// $this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="tarifas-update">

<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_estudios'=>$lista_estudios,
		        'ideps'=>$ideps,
		    ]) ?>
		</div>
	</div>

</div>
