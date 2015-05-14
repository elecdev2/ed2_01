<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Ips */

$this->title = 'Crear Ips';
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>
	
	<?php $listdata = ArrayHelper::map($t_id,'codigo','descripcion'); ?>
	<?php $list_client = ArrayHelper::map($clientes, 'id', 'nombre'); ?>
    <?= $this->render('_form', [
        'model' => $model, 
        'listdata' => $listdata, 
        'list_client'=> $list_client,
    ]) ?>

</div>
