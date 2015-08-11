<?php 
use yii\widgets\DetailView;
use yii\helpers\Html;
 ?>

<?php if($model !== null){ ?>
<table class="table table-condensed">
	<tr><td><strong>Archivos</strong></td></tr>
	<?php foreach ($model as $archivo) { ?>
		<tr><td><a href="<?=Yii::$app->request->baseUrl."/images/hist/".$archivo?>" target="_blank"><?=$archivo ?></a></td></tr>
	<?php } ?>

</table>
<?php } ?>