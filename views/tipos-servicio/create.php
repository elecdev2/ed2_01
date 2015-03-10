<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\TiposServicio */

$this->title = 'Crear tipos de servicio';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-servicio-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>

	<?php $list_client = ArrayHelper::map($clientes, 'id', 'nombre'); ?>
    <?= $this->render('_form', [
        'model' => $model, 'list_client' => $list_client, 'client_model' => $client_model,
    ]) ?>

</div>
