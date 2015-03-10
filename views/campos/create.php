<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Campos */

$this->title = 'Create Campos';
$this->params['breadcrumbs'][] = ['label' => 'Campos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
