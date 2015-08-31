<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\AntecedentesPatologicos;
use app\models\AntecedentesFamiliares;
use app\models\Habitos;
use app\models\RevSistemas;
use app\models\ExamenFisico;
use app\models\ExploracionRegional;
use app\models\AnalisisDiag;
use app\models\AnalisisImpresionDiagnostica;
use app\models\Ciudades;
use app\models\ListasSistema;

/* @var $this yii\web\View */
/* @var $model app\models\HistoriaClinica */

$this->title = 'Historia clínica '.$model->id;

?>
<div class="historia-clinica-view">
    
    <h3>Datos del paciente</h3>

    <div class="panel panel-default">
 
        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <tr>
                <td><strong>Tipo de documento</strong></td>
                <td><?=$paciente->tipo_identificacion?></td>
                <td><strong>Número de documento</strong></td>
                <td><?=$paciente->identificacion?></td>
            </tr>
            <tr>
                <td><strong>Nombres</strong></td>
                <td><?=$paciente->nombre1.' '.$paciente->nombre2 ?></td>
                <td><strong>Apellidos</strong></td>
                <td><?=$paciente->apellido1.' '.$paciente->apellido2 ?></td>
            </tr>
            <tr>
                <td><strong>Sexo</strong></td>
                <td><?=$paciente->sexo == 'F' ? 'Femenino' : 'Masculino' ?></td>
                <td><strong>Fecha de nacimiento</strong></td>
                <td><?=date('F j, Y', strtotime($paciente->fecha_nacimiento)) ?></td>
            </tr>
            <tr>
                <td><strong>Dirección</strong></td>
                <td><?=$paciente->direccion ?></td>
                <td><strong>Ciudad</strong></td>
                <td><?=Ciudades::findOne($paciente->idciudad)->nombre ?></td>
            </tr>
            <tr>
                <td><strong>Telefono</strong></td>
                <td><?=$paciente->telefono ?></td>
                <td><strong>E-mail</strong></td>
                <td><?=$paciente->email ?></td>
            </tr>
            <tr>
                <td><strong>Tipo de usuario</strong></td>
                <td><?=ListasSistema::find()->select(['descripcion'])->where(['codigo'=>1, 'tipo'=>'tipo_usuario'])->scalar() ?></td>
                <td><strong>Afiliación</strong></td>
                <td><?=$paciente->ideps0->nombre ?></td>
            </tr>

        </table>

    </div>

    <h3>Motivo - enfermedad actual</h3>

    <div class="panel panel-default">

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <tr><td class="theader-width"><strong>Motivo de la consulta</strong></td><td><?=$motivo == null ? '' : $motivo->motivo ?></td></tr>
            <tr><td class="theader-width"><strong>Enfermedad actual</strong></td><td><?=$motivo == null ? '' : $motivo->enfermedad ?></td></tr>
        </table>

    </div>


    <h3>Antecedentes patológicos</h3>
    
    <div class="panel panel-default">

        <?php if($ant_patologicos == null){ ?>
        
        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (AntecedentesPatologicos::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td><td></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($ant_patologicos->fields() as $key => $value) { 
                if($value != 'otros' && $value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$ant_patologicos->getAttributeLabel($value) ?></strong></td><td class="tbody-width"><?= substr($ant_patologicos->getAttribute($value),0,1) == '1' ? 'Si': 'No'?></td><td><?= substr($ant_patologicos->getAttribute($value),2) ?></td>
                    </tr>
                
                <?php }
            } ?>
            <tr>
                <td class="theader-width"><strong>Otros</strong></td><td></td><td><?=$ant_patologicos->otros ?></td>
            </tr>
        </table>

        <?php } ?>

    </div>

    <h3>Antecedentes familiares</h3>
    
    <div class="panel panel-default">

        <?php if($ant_familiares == null){ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (AntecedentesFamiliares::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td><td></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($ant_familiares->fields() as $key => $value) { 
                if($value != 'otros' && $value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$ant_familiares->getAttributeLabel($value) ?></strong></td><td class="tbody-width"><?= substr($ant_familiares->getAttribute($value),0,1) == '1' ? 'Si': 'No'?></td><td><?= substr($ant_familiares->getAttribute($value),2) ?></td>
                    </tr>
                
                <?php } 
            } ?>
            <tr>
                <td class="theader-width"><strong>Otros</strong></td><td class="tbody-width"></td><td><?=$ant_familiares->otros ?></td>
            </tr>
        </table>

        <?php } ?>

    </div>


    <h3>Habitos</h3>

    <div class="panel panel-default">

        <?php if($habitos == null){ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (Habitos::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($habitos->fields() as $key => $value) { 
                if($value != 'otros' && $value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$habitos->getAttributeLabel($value) ?></strong></td><td class="tbody-width"><?= substr($habitos->getAttribute($value),0,1) == '1' ? 'Si': 'No'?></td><td><?= substr($habitos->getAttribute($value),2) ?></td>
                    </tr>
                
                <?php }
            } ?>
            <tr>
                <td class="theader-width"><strong>Otros</strong></td><td class="tbody-width"></td><td><?=$habitos->otros ?></td>
            </tr>
        </table>

        <?php } ?>

    </div>


    <h3>Revisión de sistemas</h3>

    <div class="panel panel-default">

        <?php if($rev_sistemas == null){ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (RevSistemas::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td><td></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($rev_sistemas->fields() as $key => $value) { 
                if($value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$rev_sistemas->getAttributeLabel($value) ?></strong></td><td class="tbody-width"><?= substr($rev_sistemas->getAttribute($value),0,1) == '1' ? 'Normal': 'Irregular'?></td><td><?= substr($rev_sistemas->getAttribute($value),2) ?></td>
                    </tr>
                
                <?php }
            } ?>
        </table>

        <?php } ?>
    
    </div>


    <h3>Examen Físico</h3>

    <div class="panel panel-default">

        <?php if($ex_fisico == null){ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (ExamenFisico::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td><td></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($ex_fisico->fields() as $key => $value) { 
                if($value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$ex_fisico->getAttributeLabel($value) ?></strong></td><td><?= $ex_fisico->getAttribute($value) ?></td>
                    </tr>
                
                <?php }
            } ?>
        </table>

        <?php } ?>

    </div>

    <h3>Exploración regional</h3>

    <div class="panel panel-default">

        <?php if($exp_regional == null){ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach (ExploracionRegional::attributeLabels() as $key => $value) { ?>
                <?php if($key != 'id' && $key != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$value ?></strong></td><td></td>
                    </tr>
                <?php } ?>
           <?php } ?>
        </table>

        <?php }else{ ?>

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
            <?php foreach ($exp_regional->fields() as $key => $value) { 
                if($value != 'id' && $value != 'id_historia'){ ?>
                    <tr>
                        <td class="theader-width"><strong><?=$exp_regional->getAttributeLabel($value) ?></strong></td><td class="tbody-width"><?= substr($exp_regional->getAttribute($value),0,1) == '1' ? 'Normal': 'Irregular'?></td><td><?= substr($exp_regional->getAttribute($value),2) ?></td>
                    </tr>
                
                <?php }
            } ?>
        </table>

        <?php } ?>

    </div>

    <h3>Análisis e impresión diagnostica</h3>

    <div class="content-disabled">
        <?=$analisis;?>
    </div>

    <div class="panel panel-default">

        <?php if($diagnosticos !== null){ ?>
            <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap table-condensed">
                <?php foreach ($diagnosticos as $key => $value) { ?>
                    <tr>
                        <td><?=$key ?></td><td><?=$value ?></td>
                    </tr>
               <?php } ?>
            </table>
        <?php } ?>

    </div>
    
    <h3>Recomendaciones</h3>

    <div class="content-disabled">
        <?=$recomendaciones == null ? '' : $recomendaciones->recomendaciones;?>
    </div>
    <div class="text-right" style="<?=$impresion == false ? 'display:block' : 'display:none'?>">
        <?= Html::a('<i class="add icon-imprimir"></i>Imprimir',['imprimir-rf', 'id'=>$recomendaciones == null ? 0 : $recomendaciones->id, 't'=> 'r'],['disabled'=>$recomendaciones == null ? true : false, 'class'=>'btn btn-primary', 'title'=>'imprimir', 'target'=>'_blank']); ?>
    </div>


    <h3>Formulación</h3>

    <div class="content-disabled">
        <?=$formulacion == null ? '' : $formulacion->formulacion;?>
    </div>
    <div class="text-right" style="<?=$impresion == false ? 'display:block' : 'display:none'?>">
        <?= Html::a('<i class="add icon-imprimir"></i>Imprimir',['imprimir-rf', 'id'=>$formulacion == null ? 0 : $formulacion->id, 't'=> 'r'],['disabled'=>$formulacion == null ? true : false, 'class'=>'btn btn-primary', 'title'=>'imprimir', 'target'=>'_blank']); ?>
    </div>


    <div class="col-sm-12">
        <?=Html::img(Yii::$app->request->baseUrl.'/images/firmas/'.$model->idMedico->ruta_firma, ['width'=>'200px', 'alt'=>'Firma médico', 'class'=>'responsive']) ?>
    </div>
    <h3><?=$model->idMedico->nombre?><small> - Médico tratante</small></h3>

</div>
