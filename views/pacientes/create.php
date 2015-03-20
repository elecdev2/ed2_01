<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pacientes */

$this->title = 'Create Pacientes';
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-create">

	<div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::a('Regresar', ['index'], ['style'=>'float:right', 'class' => 'btn btn-success btn-lg']);?>
            </div>
        </div>
    </div>

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
