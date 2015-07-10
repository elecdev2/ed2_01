<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */

$this->title = 'Editar cita médica';
// $this->params['breadcrumbs'][] = ['label' => 'Citas Medicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_citas, 'url' => ['view', 'id' => $model->id_citas]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="citas-medicas-update">
<input type="text" hidden name="id_help" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">

	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'paciente'=>$paciente,
		        'rango_fecha'=>$rango_fecha,
		        'id_cliente'=>$id_cliente,
		        'lista_med'=>$lista_med,
		        'lista_tipoid'=>$lista_tipoid,
		        'lista_tipos'=>$lista_tipos,
		        'lista_resid'=>$lista_resid,
		        'lista_ciudades'=>$lista_ciudades,
		        'lista_eps'=>$lista_eps,
		    ]) ?>
		</div>
	</div>

	<div class="panel panel-default">
        <div class="panel-body">
			<div class="col-sm-6">
				<button class="btn btn-danger" id="cancelar_cita" onclick="cancelarCita(<?=$model->id_citas?>)" ><i class=""></i>Cancelar cita</button>
			</div>
        </div>
    </div>

</div>
