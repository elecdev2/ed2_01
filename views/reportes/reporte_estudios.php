<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div >
    <h1 style="color: blue; ">PLANILLA</h1>
    <br>
    <b style="color: blue; "><i>Rango de Fechas</i></b> <?= Html::encode(strtoupper($model->fecha_atencion)); ?> - <?= Html::encode(strtoupper($model->fecha_salida)); ?>
    <table width="100%">
        <tr width="100%" >
            <th width="10%" > <i><?= Html::encode($model->getAttributeLabel('idtipo_servicio')); ?> </i></th>
            <th width="10%"> <i><?= Html::encode($model->getAttributeLabel('numero_muestra')); ?></th>
            <th width="20%"><i><?= Html::encode($model->getAttributeLabel('idpacientes')); ?></th>
            <th width="20%"><i><?= Html::encode($model->getAttributeLabel('eps_ideps')); ?></th>
            <th width="10%"><i><?= Html::encode($model->getAttributeLabel('valor_procedimiento')); ?></th>
            <th width="10%"><i><?= Html::encode($model->getAttributeLabel('valor_copago')); ?></th>
            <th width="10%"><i><?= Html::encode($model->getAttributeLabel('valor_abono')); ?></th>
            <th width="10%" style="border-top: blue 2px solid;  border-bottom: blue 2px solid;color: blue;  "><i><?= Html::encode($model->getAttributeLabel('recibo')); ?></th>
        </tr>

        <?php
        $proc = 0;
        $abono = 0;
        $copago = 0;
        foreach ($lista as $l) {
            $proc+=$l->idprocedimiento0->valor_procedimiento == null ? 0 : $l->idprocedimiento0->valor_procedimiento;
            $abono+=$l->valor_abono == null ? 0 : $l->valor_abono;
            $copago+=$l->idprocedimiento0->valor_copago == null ? 0 : $l->idprocedimiento0->valor_copago;
            ?>
            <tr>
                <td><?= Html::encode(strtoupper($l->idprocedimiento0->idtipo_servicio)); ?></td>
                <td><?= Html::encode(strtoupper($l->idprocedimiento0->numero_muestra)); ?></td>
                <td><?= Html::encode(strtoupper($l->idprocedimiento0->idpacientes0->nombre1 . ' ' . $l->idprocedimiento0->idpacientes0->nombre2 . ' ' . $l->idprocedimiento0->idpacientes0->apellido1 . ' ' . $l->idprocedimiento0->idpacientes0->apellido2)); ?></td>
                <td><?= Html::encode(strtoupper($l->idprocedimiento0->epsIdeps->nombre)); ?></td>
                <td><?= Html::encode(number_format($l->idprocedimiento0->valor_procedimiento)); ?></td>
                <td><?= Html::encode(number_format($l->idprocedimiento0->valor_copago)); ?></td>
                <td><?= Html::encode(number_format($l->valor_abono)); ?></td>
                <td><?= Html::encode(strtoupper($l->num_recibo)); ?></td>
            </tr>

            <?php
        }
        ?>
        <tr>
            <td colspan="3" style="text-align: center; "  ><b style="color: blue;"><i>Totales:</i></b></td>
            <td><?= Html::encode(sizeof($lista)); ?></td>
            <td><?= Html::encode(number_format($proc)); ?></td>
            <td><?= Html::encode(number_format($copago)); ?></td>
            <td><?= Html::encode(number_format($abono)); ?></td>
            <td></td>
        </tr>
    </table>
</div>