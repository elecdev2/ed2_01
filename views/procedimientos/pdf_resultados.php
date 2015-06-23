<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

?>

<div class="procedimientos-form">
	
	<?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'estForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

		<!-- TODO datos del paciente -->

		<div class="text-center">
			<h4><?= Html::encode($model->epsIdeps->idips0->nombre) ?></h4>
			<p><i><?= Html::encode($model->epsIdeps->idips0->descripcion); ?></i></p>

			<?= Html::encode($model->epsIdeps->idips0->direccion); ?> TEL. <?= Html::encode($model->epsIdeps->idips0->telefono); ?>
	        <br>
	        BARRANQUILLA-COLOMBIA
	        <br><br>

        </div>

		<div class="panel panel-default">
            <div class="panel-body">
		        <table width="100%" <?= "class='".$model->idtipoServicio->nombre."'" ?> >
		            <tr width="100%" >
		                <td width="20%"><b><?= Html::encode(strtoupper($model->getAttributeLabel('paciente'))); ?>:</b></td>
		                <td width="30%"><?= Html::encode(mb_strtoupper($model->idpacientes0->nombre1 . ' ' . $model->idpacientes0->nombre2 . ' ' . $model->idpacientes0->apellido1 . ' ' . $model->idpacientes0->apellido2,'utf-8')); ?></td>
		                <td width="25%"><b><?= Html::encode(mb_strtoupper($model->getAttributeLabel('numero_muestra'),'utf-8')); ?>:</b></td>
		                <td width="25%"><?= Html::encode(strtoupper($model->numero_muestra)); ?></td>
		            </tr>
		            <tr>
		                <td><b><?= Html::encode(strtoupper($model->idpacientes0->tipo_identificacion)); ?>:</b></td>
		                <td><?= Html::encode(strtoupper($model->idpacientes0->identificacion)); ?></td>
		                <td><b><?= Html::encode(strtoupper('edad')); ?>:</b></td>
                		<td><?= Html::encode(date_diff(date_create($model->idpacientes0->fecha_nacimiento), date_create(date('Y-m-d')))->y ); ?></td>
		            </tr>

		            <tr>
		                <td><b><?= Html::encode(mb_strtoupper($model->getAttributeLabel('fecha_atencion'),'utf-8')); ?>:</b></td>
		                <td><?= Html::encode(strtoupper(Yii::$app->formatter->asDate($model->fecha_atencion, 'long'))); ?></td>
		                <td><b><?= Html::encode(strtoupper($model->getAttributeLabel('fecha_salida'))); ?>:</b></td>
		                <td><?= Html::encode(strtoupper(Yii::$app->formatter->asDate($model->fecha_informe, 'long'))); ?></td>
		            </tr>
		            <tr>
		                <td><b><?= Html::encode(strtoupper($model->getAttributeLabel('eps_ideps'))); ?>:</b></td>
		                <td><?= Html::encode(mb_strtoupper($model->epsIdeps->nombre,'utf-8')); ?></td>
		                <td><b><?= Html::encode(mb_strtoupper($model->getAttributeLabel('telefono'),'utf-8')); ?>:</b></td>
		                <td><?= Html::encode(strtoupper($model->idpacientes0->telefono)); ?></td>
		            </tr>
		            <tr>
		                <td><b><?= Html::encode(mb_strtoupper($model->getAttributeLabel('medico'),'utf-8')); ?>:</b></td>
		                <td><?= Html::encode(mb_strtoupper($model->idmedico0->nombre,'utf-8')); ?></td>
		                <td></td>
		                <td></td>
		            </tr>
		        </table>
	    	</div>
	    </div>
			
	        <div class="panel panel-default">
	            <div class="panel-body">
	                <?= $this->render('form_estudios', [
	                        'campos'=>$campos,
	                        'model'=>$model,
	                        'form'=>$form,
	                        'imp'=>1,
	                ]) ?>
	            </div>
	        </div>

	    <div style="text-align: right;" >
	        <?= Html::img(Yii::$app->request->baseUrl.'/images/firmas/'.$model->idmedico0->ruta_firma, ['width'=>'200px', 'alt'=>'Firma médico', 'class'=>'responsive']) ?> <br>
	        DOCUMENTO FIRMADO DIGITALMENTE <br>
	        <?= Html::encode(strtoupper($model->idmedico0->nombre)); ?>
    	</div>
        

	<?php ActiveForm::end(); ?>
</div>