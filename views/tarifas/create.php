<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = 'Crear tarifas';
$this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarifas-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
	
	<div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'ideps'=>$ideps,
		        'lista_estudios'=>$lista_estudios,
		    ]) ?>
		</div>
	</div>

</div>
