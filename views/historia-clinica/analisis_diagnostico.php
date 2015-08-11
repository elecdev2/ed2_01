<?php 
use yii\widgets\DetailView;
 ?>

<table class="table table-condensed">
    <td><strong>Análisis</strong></td>
    <td><?=$analisis ?></td>
</table>

<?php if($diagnosticos !== null){ ?>
 <table class="table table-condensed">
    <?php foreach ($diagnosticos as $key => $value) { ?>
        <tr>
            <td><strong><?=$key ?></strong></td><td><?=$value ?></td>
        </tr>
   <?php } ?>
</table>
<?php } ?>