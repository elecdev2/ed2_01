<?php 
use yii\widgets\DetailView;
use yii\helpers\Html;
 ?>

<?php if($model !== null){ ?>
<table class="table table-condensed">
    <td><strong>Formulación</strong></td>
    <td><?=Html::encode($model->formulacion) ?></td>
</table>
<?php } ?>
