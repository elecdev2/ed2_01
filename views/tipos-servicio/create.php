<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\TiposServicio */

$this->title = 'Crear tipos de servicio';
// $this->params['breadcrumbs'][] = ['label' => 'Tipos Servicios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-servicio-create">

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

	<?php $list_client = ArrayHelper::map($clientes, 'id', 'nombre'); ?>
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model, 'list_client' => $list_client, 'client_model' => $client_model,
		    ]) ?>
		</div>
	</div>

</div>
