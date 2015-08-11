<?php
use app\models\PlantillasDiagnosticos;
use app\models\Usuarios;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->numero_muestra;
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="procedimientos-update">

   <!--  <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?//echo Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div> -->
<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <?= $this->render('_form', [
        'model' => $model, 
        'paciente_model'=>$paciente_model,
        'ips_model'=>$ips_model,
        'ips_list'=>$ips_list,
        'lista_tipos'=>$lista_tipos,
        'lista_tipoid'=>$lista_tipoid,
        'lista_resid'=>$lista_resid,
        'lista_ciudades'=>$lista_ciudades,
        'lista_eps'=>$lista_eps,
        'lista_pago'=>$lista_pago,
        'lista_med'=>$lista_med,
        'rango_fecha'=>$rango_fecha,
        'cita_model'=> $cita_model,
    ]) ?>

</div>
