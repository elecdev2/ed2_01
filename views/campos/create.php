<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Campos */

$this->title = 'Crear campo';
$this->params['breadcrumbs'][] = ['label' => 'Campos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campos-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>
	
	<?php $list_client = ArrayHelper::map($clientes,'id','nombre'); ?>
	<?php $titulos_list = ArrayHelper::map($titulos,'id','descripcion'); ?>
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
