<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estudios */

$this->title = 'Create Estudios';
$this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
