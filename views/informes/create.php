<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Informes */

$this->title = 'Create Informes';
// $this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloCrear col-md-12">
                <div class="col-md-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-md-6">
                    <?= Html::a('<i class="add icon-back"></i>Regresar', ['index'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>

		</div>
	</div>

</div>
