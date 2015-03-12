<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ListasSistema */

$this->title = 'Crear Lista';
$this->params['breadcrumbs'][] = ['label' => 'Listas Sistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listas-sistema-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
