<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */

$this->title = 'Nueva cita médica';
// $this->params['breadcrumbs'][] = ['label'=> 'Citas Medicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?> 
<div class="citas-medicas-create">
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

</div>
