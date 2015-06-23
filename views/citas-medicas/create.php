<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */

$this->title = 'Nueva cita médica';
// $this->params['breadcrumbs'][] = ['label'=> 'Citas Medicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?> 
<div class="citas-medicas-create">
<input type="text" hidden name="id_help" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
   <div class="panel panel-default">
        <div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'lista_med'=>$lista_med,
		    ]) ?>
		</div>
	</div>

</div>
