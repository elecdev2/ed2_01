<?php 
use yii\widgets\DetailView;
use yii\helpers\Html;
 ?>

<?php if($model !== null){ ?>
<table class="table table-condensed">
	<?php foreach ($model as $key => $value) { ?>
		<tr>
			<td><strong><?=$value['nombre'] ?></strong></td>
			<td>
			<?=	$value['valor'] == 1 ? 'Si' : $value['valor']?>
			</td>
		</tr>
	<?php } ?>
</table>
<?php } ?>
