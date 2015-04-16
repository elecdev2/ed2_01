<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Crear procedimiento';
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-create col-md-12">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::a('Regresar', ['index'], ['style'=>'float:right', 'class' => 'btn btn-success btn-lg']);?>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
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
            ]) ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        nombrePaciente('#documento', '#procedimientos-idpacientes', '#pacienteName', '#pacientes-direccion','#pacientes-telefono','#pacientes-fecha_nacimiento','#edad', '#pacientes-email');
    });
</script>
