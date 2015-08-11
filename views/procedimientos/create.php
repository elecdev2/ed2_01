<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Nuevo procedimiento';
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
    
   <!--  <div class="panel panel-default">
        <div class="panel-body"> -->

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
                'id_cliente'=>$id_cliente,
                'lista_pago'=>$lista_pago,
                'lista_med'=>$lista_med,
                'medicoRemModel'=>$medicoRemModel,
                'lista_especialidades'=>$lista_especialidades,
                'lista_medRemGen'=>$lista_medRemGen,
                'rango_fecha'=>$rango_fecha,
            ]) ?>
        <!-- </div>
    </div> -->

</div>
<script type="text/javascript">
    $(document).ready(function() {
        nombrePaciente('#documento', '#procedimientos-idpacientes', '#pacienteName','#pacientes-nombre1','#pacientes-nombre2','#pacientes-apellido1','#pacientes-apellido2', '#pacientes-direccion','#pacientes-telefono','#pacientes-fecha_nacimiento','#pacientes-codeps', '#pacientes-email', '#tipoID');
    });
</script>
