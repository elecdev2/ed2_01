<?php 
use yii\helpers\Html;
use app\models\ListasSistema;
date_default_timezone_set('America/Bogota');
 ?>

 <div class="procedimientos-form">
	
	<div class="text-center">
		<h4><?= Html::encode($model->epsIdeps->idips0->nombre) ?></h4>
		<p><i><?= Html::encode($model->epsIdeps->idips0->descripcion); ?></i></p>

		<?= Html::encode($model->epsIdeps->idips0->direccion); ?> TEL. <?= Html::encode($model->epsIdeps->idips0->telefono); ?>
        <br>
        BARRANQUILLA-COLOMBIA
        <br><br>
    </div>

    <div style="text-align:right">
        <h3 style="text-align:right"><b>FACTURA DE VENTA No.<?= Html::encode($model->numero_factura); ?></b></h3>
	</div>

	<div class="panel panel-default">
        <div class="panel-body">
	        <table width="100%">
				<tr>
					<td>Fecha: <span><?= Html::encode($model->periodo_facturacion); ?></span></td>
					<td></td>
				</tr>
				<tr>
					<td>Señor(es): <span><?= Html::encode($model->epsIdeps->nombre); ?></span></td>
					<td>NIT: <span><?= Html::encode($model->epsIdeps->nit); ?></span></td>
				</tr>
				<tr>
					<td>Dirección: <span><?= Html::encode($model->epsIdeps->direccion); ?></span></td>
					<td>Teléfono: <span><?= Html::encode($model->epsIdeps->telefono); ?></span></td>
				</tr>

	        </table><br>

	        <div>
	        	<p>Debe a: <br><?=Html::encode($model->epsIdeps->idips0->nombre); ?> la suma de $<?=Html::encode($model->valor_procedimiento-$model->descuento); ?></p>
	        	<p>Por concepto de: <br> <?php $sis = ListasSistema::find()->where(['tipo'=>'concepto_fact'])->one(); echo Html::encode($sis->descripcion)?> </p><br>
	        	
	        	<p><b>TOTAL: <span>$<?= Html::encode($model->valor_procedimiento); ?></span></b></p>
	        	<p><b>DESCUENTOS: <span>$<?= Html::encode($model->descuento); ?></span></b></p>
	        	<p><b>TOTAL A PAGAR: <span>$<?= Html::encode($model->valor_procedimiento - $model->descuento); ?></span></b></p><br>

	        	<p>TOTAL ORDENES: <span><?=Html::encode($model->cantidad_muestras); ?></span></p><br>

	        	<p><b>Observación: </b><br>Todas las ordenes de servicio de esta factura van foliadas en orden consecutivo</p><br>
				<br>
				<p><?=Html::encode(strtoupper($model->epsIdeps->idips0->representante_legal)); ?><br><b>REPRESENTANTE LEGAL</b></p>

	        </div>
	    </div>
	</div>


 </div>