<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div >
    <h1 style="color: blue; ">REPORTE SALDOS PENDIENTES</h1>
    <br>
    <b style="color: blue; "><i>Rango de Fechas</i></b> <?= Html::encode(strtoupper($model->fecha_atencion)); ?> - <?= Html::encode(strtoupper($model->fecha_salida)); ?>
        <table width="100%">
            <tr>
                <th><i><?= Html::encode($model->getAttributeLabel('fecha_atencion')); ?> </i></th>
                <th><i><?= Html::encode($model->getAttributeLabel('idtipo_servicio')); ?> </i></th>
                <th><i><?= Html::encode($model->getAttributeLabel('numero_muestra')); ?></th>
                <th><i><?= Html::encode($model->getAttributeLabel('paciente')); ?></th>
                <th><i><?= Html::encode($model->getAttributeLabel('eps_ideps')); ?></th>
                <th><i><?= Html::encode($model->getAttributeLabel('valor_procedimiento')); ?></th>
                <th><i><?= Html::encode($model->getAttributeLabel('valor_copago')); ?></th>
                <th><i><?= Html::encode($model->getAttributeLabel('valor_abono')); ?></th>
                <th><i><?= Html::encode('saldo pendiente'); ?></th>
            </tr>
    
    <?php
    $proc=0;
    $abono=0;
    $copago=0;
    foreach ($lista as $l) {
        $proc+=$l->valor_procedimiento==null?0:$l->valor_procedimiento;
        $abono+=$l->valor_abono==null?0:$l->valor_abono;
        $copago+=$l->valor_copago==null?0:$l->valor_copago;
        $saldo+=$l->valor_saldo==null?0:$l->valor_saldo;
            ?>
            <tr>
                <td><?= Html::encode(strtoupper($l->fecha_atencion)); ?></td>
                <td><?= Html::encode(strtoupper($l->idtipo_servicio)); ?></td>
                <td><?= Html::encode(strtoupper($l->numero_muestra)); ?></td>
                <td><?= Html::encode(strtoupper($l->idpacientes0->nombre1 . ' ' . $l->idpacientes0->nombre2 . ' ' . $l->idpacientes0->apellido1 . ' ' . $l->idpacientes0->apellido2)); ?></td>
                <td><?= Html::encode(strtoupper($l->epsIdeps->nombre)); ?></td>
                <td><?= Html::encode(number_format($l->valor_procedimiento)); ?></td>
                <td><?= Html::encode(number_format($l->valor_copago)); ?></td>
                <td><?= Html::encode(number_format($l->valor_abono)); ?></td>
                <td><?php  echo  CHtml::encode(number_format($l->valor_saldo)); ?></td>
            </tr>

            <?php
        }
    ?>
            <tr>
               <td colspan="4" style="text-align: center; "  ><b style="color: blue;"><i>Totales:</i></b></td>
               <td><?= Html::encode(sizeof($lista)); ?></td>
               <td><?= Html::encode(number_format($proc)); ?></td>
                <td><?= Html::encode(number_format($copago)); ?></td>
                <td><?= Html::encode(number_format($abono)); ?></td>
                <td><?= Html::encode(number_format($saldo)); ?></td>
        
            </tr>
    </table>
    </div>