<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->numero_muestra;
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-view">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6 tituloMd6">
                <h1 class="titulo tituloDetalle"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6 tituloMd6">
                <?php if($model->estado == 'FRM' || $model->estado == 'FCT'){ ?>

                    <?= Html::a('Vista previa', ['print', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'target'=>'_blank',
                        'data' => [
                            'confirm' => '¿Seguro que desea visualizar el resultado?',
                            'method' => 'post',
                        ],
                    ]); ?>

                    <?= Html::a('Imprimir recibo', ['generar-recibo', 'id' => $model->id, 'vista'=>3], [
                        'class' => 'btn btn-default',
                        'target'=>'_blank',
                        'data' => [
                            'confirm' => '¿Seguro que desea imprimir el último recibo?',
                            'method' => 'post',
                        ],
                    ]); ?>

                    <?= Html::button(
                    'Recibos',
                    ['value' => Url::to(['procedimientos/generar-recibo?id='.$model->id.'&vista=1']),
                        'class'=>'btn btn-default updModal',
             
                    ]) ?>

                <?php } ?>
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['procedimientos/update?id='.$model->id]),
                    'class'=>'update upd updModal',
                    'style'=>'float:right',
         
                ]) ?>
                <!-- <button id="actualizar" class="btn btn-primary btn-lg"></button> -->
            </div>
        </div>
    </div>


 <!--    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',

            [
                'attribute'=>'idpacientes',
                'label'=>'Cédula del paciente',
                'value'=> $model->idpacientes0->identificacion,
            ],
            // 'idpacientes',
            'fecha_atencion',
            'autorizacion',
            'numero_muestra',
            'valor_procedimiento',
            [
                'attribute'=>'eps_ideps',
                'label'=>'EPS',
                'value'=> $model->epsIdeps->nombre,
            ],
            // 'eps_ideps',
            'cod_cups',
            'cantidad_muestras',
            'valor_copago',
            'valor_saldo',
            'valor_abono',
            [
                'attribute',
                'label'=>'Médico remitente',
                'value'=>$model->medico == null ? '' : $model->medico0->nombre,
            ],
            // 'medico',
            'observaciones',
            'forma_pago',
            'numero_cheque',
            'estado',
            'fecha_informe',
            'numero_factura',
            'fecha_salida',
            'fecha_entrega',
            'periodo_facturacion',
            [
                'attribute'=>'idtipo_servicio',
                'label'=>'Estudio',
                'value'=> $model->idtipoServicio->nombre,
            ],
            // 'idtipo_servicio',
            [
                'attribute'=>'idmedico',
                'label'=>'Médico',
                'value'=> $model->nombreMedico,
            ],
            // 'idmedico',

            [
                'attribute'=>'usuario_recibe',
                'label'=>'Usurio recibe',
                'value'=> $model->usuarioRecibe->nombre,
            ],
            // 'usuario_recibe',

            [
                'attribute'=>'usuario_transcribe',
                'label'=>'Usurio transcribe',
                'value'=> $model->nombreUsuarioTrasncribe,
            ],
            // 'usuario_transcribe',
            'descuento',
        ],
    ]) ?>

</div>
