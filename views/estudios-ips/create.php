<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EstudiosIps */

$this->title = 'Create Estudios Ips';
$this->params['breadcrumbs'][] = ['label' => 'Estudios Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudios-ips-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
