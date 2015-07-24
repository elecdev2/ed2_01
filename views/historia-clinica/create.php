<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HistoriaClinica */

$this->title = 'Create Historia Clinica';
$this->params['breadcrumbs'][] = ['label' => 'Historia Clinicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historia-clinica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
