<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Nueva consulta';
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-create col-md-12">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloCrear col-md-12">
                <div class="col-md-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-md-6">
                    <?= Html::a('<i class="add icon-back"></i>Regresar', ['index'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
        </div>
    </div>
    
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
