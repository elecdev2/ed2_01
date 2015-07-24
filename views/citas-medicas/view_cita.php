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

<?php if(Yii::$app->user->can('medico') && (strtotime($model->fecha) == strtotime(date('Y-m-d')))){ ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-6">
            <button class="btn btn-primary" id="historia_clinica" data-dismiss="modal" data-paciente="<?=$model->pacientes_id?>" data-medico="<?=$model->medicos_id?>" onclick="abrirHistoria()" ><i class=""></i>Ver historia clinica</button>
        </div>
    </div>
</div>
<?php } ?>

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
                
                'motivo',
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
            <button class="btn btn-success" id="atencion" onclick="alert('Formulario atención')" ><i class=""></i>Atender paciente</button>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-danger" id="cancelar_cita" onclick="cancelarCita(<?=$model->id_citas?>)" ><i class=""></i>Cancelar cita</button>
        </div>
    </div>
</div>

<?php } ?>

</div>

<div id="historiaModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="titulo-tarifa"><?=$paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2 ?></h3>
            </div>
            <div class="modal-body">
                <div id='historia'></div>
            </div>
        </div>
    </div>
</div>