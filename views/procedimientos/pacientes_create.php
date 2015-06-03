<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = 'Nuevo paciente';
// $this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-create">

     <div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('pacientes_form', [
		        'model' => $model,
		        'lista_tipos'=>$lista_tipos,
		        'lista_tipoid'=>$lista_tipoid,
		        'lista_resid'=>$lista_resid,
		        'lista_ciudades'=>$lista_ciudades,
		        'lista_eps'=>$lista_eps,
		        'id_cliente'=>$id_cliente,
                'rango_fecha'=>$rango_fecha,
		    ]) ?>
		</div>
	</div>

</div>
