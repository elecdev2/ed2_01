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

<div class="panelFormulario-contenido">
    <div class="panelFormulario-header">
        <h3 class="titulo-tarifa">Datos del paciente</h3>
    </div>
    <div class="modal-body">
	    <?= DetailView::widget([
	        'model' => $paciente,
	        'attributes' => [
	            [
	            	'attribute'=>'nombre',
	            	'value'=>$paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2,
	            ],
	            [
	            	'attribute'=>'identificacion',
	            	'value'=>$paciente->tipo_identificacion.' '.$paciente->identificacion,
	            ],
	            'telefono',
	            'email:email',
	        ],
	    ]) ?>
	</div>
</div>

	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_med'=>$lista_med,
		    ]) ?>
		</div>
	</div>

</div>
