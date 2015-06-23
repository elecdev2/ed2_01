<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Nuevo usuario';
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-create">

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
		        'id_cliente'=>$id_cliente,
                'lista_perf'=>$lista_perf,
                'lista_ips'=>$lista_ips,
                'lista_especialidades'=>$lista_especialidades,
                'ipsModel'=>$ipsModel,
                
                // 'lista_clientes'=>$lista_clientes,
		    ]) ?>
		</div>
	</div>

</div>
