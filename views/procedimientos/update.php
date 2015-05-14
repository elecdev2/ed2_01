<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->numero_muestra;
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="procedimientos-update">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'paciente_model'=>$paciente_model,
        'ips_model'=>$ips_model,
        'ips_list'=>$ips_list,
        'lista_estados'=>$lista_estados,
        'lista_pago'=>$lista_pago,
        'lista_med'=>$lista_med,
        'lista_medRemGen'=>$lista_medRemGen,
        'medicoRemModel'=>$medicoRemModel,
        'lista_especialidades'=>$lista_especialidades,
        'campos'=>$campos,

    ]) ?>

</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#pacientes-fecha_nacimiento').val('<?=$model->idpacientes0->fecha_nacimiento?>');	
	});
</script>
