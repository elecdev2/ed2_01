<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MedicosRemitentes */

$this->title = 'Create Medicos Remitentes';
$this->params['breadcrumbs'][] = ['label' => 'Medicos Remitentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-remitentes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
