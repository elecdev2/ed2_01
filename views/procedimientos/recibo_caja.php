<?php

use yii\helpers\Html;

?>

<div class="row">
	
		<div class="text-center">
			<h4><?= Html::encode($model->idprocedimiento0->epsIdeps->idips0->nombre) ?></h4>
			<p><i><?= Html::encode($model->idprocedimiento0->epsIdeps->idips0->descripcion); ?></i></p>

			<?= Html::encode($model->idprocedimiento0->epsIdeps->idips0->direccion); ?> TEL. <?= Html::encode($model->idprocedimiento0->epsIdeps->idips0->telefono); ?>
	        <br>
	        BARRANQUILLA-COLOMBIA
	        <br><br>

        </div>

        <h4>Recibo de caja N°<?= Html::encode($model->num_recibo) ?></h4>

		        <table width="100%" <?= "class='".$model->idprocedimiento0->idtipoServicio->nombre."'" ?> >
		            <tr width="100%" >
		                <td width="20%"><b>PACIENTE</b></td>
		                <td width="30%"><?= Html::encode(mb_strtoupper($model->idprocedimiento0->idpacientes0->nombre1 . ' ' . $model->idprocedimiento0->idpacientes0->nombre2 . ' ' . $model->idprocedimiento0->idpacientes0->apellido1 . ' ' . $model->idprocedimiento0->idpacientes0->apellido2,'utf-8')); ?></td>
		            </tr>
		            <tr>
		                <td><b>IDENTIFICACION</b></td>
		                <td><?= Html::encode(strtoupper($model->idprocedimiento0->idpacientes0->identificacion)); ?></td>
		            </tr>
	              	<tr>
		              	<td><b>EDAD</b></td>
                		<td><?= Html::encode(date_diff(date_create($model->idprocedimiento0->idpacientes0->fecha_nacimiento), date_create(date('Y-m-d')))->y ); ?></td>
					</tr>
		            <tr>
		            	<td><b>TELEFONO</b></td>
		            	<td><?= Html::encode(strtoupper($model->idprocedimiento0->idpacientes0->telefono))  ?></td>
		            </tr>
		            <tr>
		            	<td><b>ENTIDAD</b></td>
		            	<td><?= Html::encode(strtoupper($model->idprocedimiento0->epsIdeps->idips0->nombre))  ?></td>
		            </tr>
		            <tr>
		            	<td><b>ESTUDIO SOLICITADO</b></td>
		            	<td><?= Html::encode(strtoupper($model->idprocedimiento0->cod_cups)) ?></td>
		            </tr>
		            <tr>
		           		<td><b>VALOR ESTUDIO</b></td>
		           		<td><?= Html::encode("$ ".number_format($model->idprocedimiento0->valor_procedimiento,0)) ?></td>
		           	</tr>
		           	<tr>
		           		<td><b>VALOR ABONADO</b></td>
		           		<td><?= Html::encode("$ ".number_format($model->idprocedimiento0->valor_abono,0)) ?></td>
		           	</tr>
		           	<tr>
		           		<td><b>VALOR SALDO</b></td>
		           		<td><?= Html::encode("$ ".number_format($model->idprocedimiento0->valor_saldo,0)) ?></td>
		           	</tr>
		           	<tr>
		           		<td><b>FECHA ATENCION</b></td>
		           		<td><?= Html::encode(strtoupper($model->idprocedimiento0->fecha_atencion)) ?></td>
		           	</tr>
		           	<tr>
		           		<td><b>MUESTRAS RECIBIDAS</b></td>
		           		<td><?= Html::encode(strtoupper($model->idprocedimiento0->cantidad_muestras)) ?></td>
		           	</tr>
		           	<tr>
		           		<td><b>N° DE CASO</b></td>
		           		<td><?= Html::encode(strtoupper($model->idprocedimiento0->numero_muestra)) ?></td>
		           	</tr>
		        </table>

</div>