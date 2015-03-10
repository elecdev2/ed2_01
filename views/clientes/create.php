<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = 'Crear cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
