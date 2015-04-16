<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = $model->eps->nombre.' - estudio: '.$model->idestudios;
// $this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="tarifas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lista_estudios'=>$lista_estudios,
    ]) ?>

</div>
