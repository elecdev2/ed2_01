<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Crear usuario';
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-create">

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
		        'id_cliente'=>$id_cliente,
                'lista_perf'=>$lista_perf,
                'modelMedico'=>$modelMedico,
                'lista_ips'=>$lista_ips,
                'lista_especialidades'=>$lista_especialidades,
		    ]) ?>
		</div>
	</div>

</div>
