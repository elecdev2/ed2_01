<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EpsTipos */

$this->title = 'Create Eps Tipos';
$this->params['breadcrumbs'][] = ['label' => 'Eps Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-tipos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
