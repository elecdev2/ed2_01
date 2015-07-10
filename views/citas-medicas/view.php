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

<div class="panelFormulario-contenido">
    <div class="panelFormulario-header">
        <h3 class="titulo-tarifa">Datos de la cita</h3>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            [
                'attribute'=>'id_citas',
                'label'=>'Código de cita',
                'value'=>$model->id_citas,
            ],
                
                // 'pacientes_id',
                // 'medicos_id',
                'fecha',
                'hora',
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
    <div class="modal-body">

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
                'direccion',
                'telefono',
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

</div>
