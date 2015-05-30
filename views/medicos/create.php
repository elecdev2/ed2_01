<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = 'Crear médico';
// $this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloCrear col-md-12">
                <div class="col-md-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-md-6">
                    <?= Html::a('<i class="add icon-back"></i>Regresar', ['index'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
        </div>
    </div>
	
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_especialidades'=>$lista_especialidades,
		        'lista_ips'=>$lista_ips,
		        'id_cliente'=>$id_cliente
		    ]) ?>
		</div>
	</div>

</div>
