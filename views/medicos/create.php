<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = 'Create Medicos';
$this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
