<?php 

use yii\helpers\Html;
use yii\helpers\Url;
 ?>

<?php if($tipo == 1){ ?>
	<table class="table-striped" width="100%">
		<tr>
			<?php 
				$totales = false;
				foreach ($campos as $c) { 

					if($c->idcolumna0->total){
						${$c->idcolumna0->alias} = 0;
						$totales = true;
					}?>
		        	<th class="" > <?= Html::encode($c->idcolumna0->descripcion); ?></th>

		    <?php } ?>
		</tr>

		<?php foreach ($lista as $l) { ?>
				<tr>
					<?php foreach ($campos as $c) {

						if($c->idcolumna0->total){
							${$c->idcolumna0->alias}+=$fact == false ? $l[$c->idcolumna0->alias] : $l->{$c->idcolumna0->alias}; 
						?>
							<td class="">$<?= Html::encode(number_format($fact == false ? $l[$c->idcolumna0->alias] : $l->{$c->idcolumna0->alias})); ?></td>
						<?php }else{ ?>
							<td class=""><?= Html::encode(strtoupper($fact == false ? $l[$c->idcolumna0->alias] : $l->{$c->idcolumna0->alias})); ?></td>
						<?php } ?>

					<?php } ?>
				</tr>
		<?php } ?>
		
		<?php if($totales){
			$i = 0;
		?>
			<tr>
				<?php foreach ($campos as $c) {

					if($c->idcolumna0->total){ ?>
						<td class=""><b>$ <?= Html::encode(number_format(${$c->idcolumna0->alias})); ?></b></td>

					<?php }else{

						if($i == 0){ ?>
							<td><b>Total factura:</b></td>
						<?php }else{ ?>
							<td></td>
						<?php } ?>

					<?php } $i++;?>

				<?php } ?>
			</tr>

		<?php } ?>
	</table>

		<?php if(!$fact){ ?>
			</br><div class="form-group">
				<?php $a = json_encode($lista);?>
				<?= Html::a('Facturar', ['facturar', 'ips'=>$ips->id, 'eps'=>$procedimientos->eps_ideps, 'fecha_inicio'=>$fecha_inicio, 'fecha_fin'=>$fecha_fin, 'lista'=>$a], ['class'=>'btn btn-success', 'target'=>'_blank']); ?>
			</div>	
		<?php } ?>

	<?php }else{ ?>
	<!-- Tabla de estudios facturados -->
	
	<table class="table-striped" width="100%">
		<tr width="100%">
			<?php foreach ($campos as $c) { ?>
				<th><?= Html::encode($c); ?></th>	
			<?php } ?>
			<th></th>
		</tr>
		
		<?php foreach ($lista as $l) { ?>
			<tr>
				<?php foreach ($campos as $c) { ?>
					<td><?= Html::encode($l[strtoupper($c)]);  ?></td>		
				<?php } ?>
				<td><?= Html::a('Detalle', ['imprimir-facturados','fac'=>$l['FACTURA'], 'id_ips'=>$l['IDIPS'], 'id_eps'=>$l['IDEPS']], ['target'=>'_blank']) ?></td>
			</tr>	
		<?php } ?>
	</table>

	<?php } ?>