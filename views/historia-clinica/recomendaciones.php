<?php 
use yii\widgets\DetailView;
use yii\helpers\Html;
 ?>

<?php if($model !== null){ ?>
<table class="table table-condensed">
    <td><strong>Recomendaciones</strong></td>
    <td><?=Html::encode($model->recomendaciones) ?></td>
</table>
<?php } ?>
