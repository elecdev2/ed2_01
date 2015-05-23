<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlantillasDiagnosticos */

$this->title = 'Crear nueva plantilla';
// $this->params['breadcrumbs'][] = ['label' => 'Plantillas Diagnosticos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantillas-diagnosticos-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h1>
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
		    ]) ?>
		</div>
	</div>

</div>
