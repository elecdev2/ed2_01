<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eps */

$this->title = 'Create Eps';
$this->params['breadcrumbs'][] = ['label' => 'Eps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
