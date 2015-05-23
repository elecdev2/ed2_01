<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlantillasDiagnosticos */

$this->title = 'Actualizar plantilla: ' . ' ' . $model->titulo;
// $this->params['breadcrumbs'][] = ['label' => 'Plantillas Diagnosticos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="plantillas-diagnosticos-update">

     <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
