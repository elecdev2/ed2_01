<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ListasSistema */

$this->title = 'Create Listas Sistema';
$this->params['breadcrumbs'][] = ['label' => 'Listas Sistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listas-sistema-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
