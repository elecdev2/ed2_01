<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = 'Crear Ips';
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-create">

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
	
	<?php $listdata = ArrayHelper::map($t_id,'codigo','descripcion'); ?>
	<?php $list_client = ArrayHelper::map($clientes, 'id', 'nombre'); ?>
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model, 
		        'listdata' => $listdata, 
		        'list_client'=> $list_client,
		    ]) ?>
		</div>
	</div>

</div>
