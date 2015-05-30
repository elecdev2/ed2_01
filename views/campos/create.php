<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Campos */

$this->title = 'Crear campo';
// $this->params['breadcrumbs'][] = ['label' => 'Campos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="campos-create">

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
	
	<?php $list_client = ArrayHelper::map($clientes,'id','nombre'); ?>
	<?php $titulos_list = ArrayHelper::map($titulos,'id','descripcion'); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model, 
                'list_client'=>$list_client, 
                'client_model'=>$client_model,
                'ips_model' => $ips_model,
                'titulos_model'=>$titulos_model,
                'titulos_list'=>$titulos_list,
                'tipo_campos'=>$tipos_campos,
            ]) ?>
        </div>
    </div>

</div>
