<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Informes */

$this->title = 'Create Informes';
$this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
