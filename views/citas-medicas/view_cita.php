<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ListasSistema;
use app\models\Ciudades;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */

$this->title = $model->id_citas;
// $this->params['breadcrumbs'][] = ['label' => 'Citas Medicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-medicas-view">



<input type="text" hidden id="helper"> <!-- input para almacenar id_cita, ips y numero de ipss (ver index evento eventClick de calendario)-->
<div class="panelFormulario-contenido">
    <div class="panelFormulario-header">
        <h3 class="titulo-tarifa">Datos de la cita</h3>
    </div>
    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            // [
            //     'attribute'=>'id_citas',
            //     'label'=>'Código de cita',
            //     'value'=>$model->id_citas,
            // ],
                
                // 'pacientes_id',
                // 'medicos_id',
            [
                'attribute'=>'fecha',
                'value'=>Yii::$app->formatter->asDate($model->fecha, 'd-MMM-yyyy'),
            ],
            [
                'attribute'=>'hora',
                'value'=>date('h:i a', strtotime($model->hora)),
            ],
            [
                'attribute'=>'tipo_servicio',
                'label'=>'Motivo de consulta',
                'value'=> $model->tipoServicio->nombre,
            ],
                
                'observaciones',
            ],
        ]) ?>
    </div>
</div>

<div class="panelFormulario-contenido">
    <div class="panelFormulario-header">
        <h3 class="titulo-tarifa">Datos del paciente</h3>
    </div>
     
    <div class="panel-body">

        <div style="margin-bottom:20px" class="">

            <?= DetailView::widget([
                'model' => $paciente,
                'attributes' => [
                    // 'id',
                    // 'tipo_identificacion',
                    [
                        'attribute'=>'identificacion',
                        'value'=>$paciente->tipo_identificacion.' '.$paciente->identificacion,
                    ],
                    [
                        'attribute'=>'nombre1',
                        'label'=>'Nombre',
                        'value'=>$paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2,
                    ],
                    'telefono',
                ],
            ]) ?>
        </div>

        <div id="vistaPaciente" class="collapse out">

            <?= DetailView::widget([
                'model' => $paciente,
                'attributes' => [
                    // 'id',
                    // 'tipo_identificacion',
                    [
                        'attribute'=>'identificacion',
                        'value'=>$paciente->tipo_identificacion.' '.$paciente->identificacion,
                    ],
                    [
                        'attribute'=>'nombre1',
                        'label'=>'Nombre',
                        'value'=>$paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2,
                    ],
                    'telefono',
                    'direccion',
                    'sexo',
                    'fecha_nacimiento',
                    [
                        'attribute'=>'tipo_usuario',
                        'label'=>'Tipo de usuario',
                        'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$paciente->tipo_usuario])->scalar(),
                    ],
                    [
                        'attribute'=>'tipo_residencia',
                        'label'=>'Tipo de residencia',
                        'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$paciente->tipo_residencia])->scalar(),
                    ],
                    // 'idclientes',
                    [
                        'attribute'=>'activo',
                        'value'=>$paciente->activo = 1 ? 'Si' : 'No',
                    ],
                    [
                        'attribute'=>'idciudad',
                        'label'=>'Ciudad',
                        'value'=>Ciudades::findOne($paciente->idciudad)->nombre,
                    ],
                    
                    [
                        'attribute'=>'ideps',
                        'label'=>'EPS',
                        'value'=>$paciente->ideps != null ? $paciente->ideps0->nombre : '',
                    ],
                    [
                        'attribute'=>'email',
                        'label'=>'Email',
                        'value'=>$paciente->email,
                    ],
                    [
                        'attribute'=>'envia_email',
                        'label'=>'Enviar email',
                        'value'=>$paciente->email = 1 ? 'Si' : 'No',
                    ],
                    'codeps',
                ],
            ]) ?>
        </div>
    </div>
     <?= Html::a('<span style="vertical-align: middle" class="glyphicon glyphicon-eye-open"></span> ver más <i class="fa fa-caret-down fa-lg"></i>','#',['data-toggle'=>'collapse','data-target'=>'#vistaPaciente', 'class'=>'search-boton']);   ?>
</div>

<?php if(strtotime($model->fecha) >= strtotime(date('Y-m-d'))){ ?>

<div class="panel panel-default">
    <div class="modal-body">
        <div class="col-sm-6 text-right">
             <?= Html::a('<i class=""></i>Atender paciente', ['atencion/create', 'p'=>$model->pacientes_id], ['class' => 'btn btn-success']); ?>
            <!-- <button class="btn btn-success" id="atencion" onclick="atender()" ><i class=""></i>Atender paciente</button> -->
        </div>
        <div class="col-sm-6">
            <button class="btn btn-danger" id="cancelar_cita" onclick="cancelarCita(<?=$model->id_citas?>)" ><i class=""></i>Cancelar cita</button>
        </div>
    </div>
</div>

<?php } ?>

</div>

