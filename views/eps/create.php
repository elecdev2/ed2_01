<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eps */

$this->title = 'Nueva EPS';
// $this->params['breadcrumbs'][] = ['label' => 'Eps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-create">

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
		        'lista_ips'=>$lista_ips,
		        'id_cliente'=>$id_cliente,
		        'lista_informes'=>$lista_informes,
                'lista_tipos'=>$lista_tipos,
		    ]) ?>
		</div>
	</div>

</div>
