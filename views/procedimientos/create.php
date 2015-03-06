<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Create Procedimientos';
$this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
