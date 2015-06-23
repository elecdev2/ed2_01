<?php

use app\models\ListasSistema;

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
    <?php if($model->estado == 'FRM' || $model->estado == 'FCT'|| $model->estado == 'IMP'|| $model->estado == 'EML'){ ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- <div class="col-md-6 tituloMd6">
                    <h1 class="titulo tituloDetalle"><?//echo Html::encode($this->title) ?></h1>
                </div> -->
                    
                <div class="col-md-12 tituloMd6">
                    <?php if($model->idpacientes0->email != null){ ?>
                         <?= Html::a('<i class="add icon-email"></i>Enviar', ['enviar-email', 'model_id'=>$model->id, 'email' => $model->idpacientes0->email,'asunto'=>'Envío de resultados'], [
                            'class' => 'imprimir btn btn-primary',
                            // 'target'=>'_blank',
                        ]); ?>
                    <?php }else{ ?>
                         <?= Html::a('<i class="add icon-email"></i>Enviar', ['enviar-email', 'model_id'=>$model->id, 'email' => $model->idpacientes0->email,'asunto'=>'Envío de resultados'], [
                            'class' => 'imprimir btn btn-primary',
                            'disabled'=>'',
                            // 'target'=>'_blank',
                        ]); ?>
                    <?php } ?>

                        <?= Html::a('<i class="add icon-imprimir"></i>Imprimir', ['print', 'id' => $model->id], [
                            'class' => 'imprimir btn btn-primary',
                            'style'=>'margin-right:10px;',
                            'target'=>'_blank',
                            // 'data' => [
                            //     'confirm' => '¿Seguro que desea visualizar el resultado?',
                            //     'method' => 'post',
                            // ],
                        ]); ?>

                        <?= Html::a('<i class="add icon-recibo"></i>Recibo', ['generar-recibo', 'id' => $model->id, 'vista'=>3], [
                            'class' => 'btn btn-success crear',
                            'style'=>'margin-right:10px;',
                            'target'=>'_blank',
                            'data' => [
                                'confirm' => 'Se generará el último recibo',
                                'method' => 'post',
                            ],
                        ]); ?>

                        <!-- <?//echo Html::button('Recibos',['value' => Url::to(['procedimientos/generar-recibo?id='.$model->id.'&vista=1']),'class'=>'btn btn-default updModal']) ?> -->

                    <!-- <button id="actualizar" class="btn btn-primary btn-lg"></button> -->
                </div>
            </div>
        </div>
    <?php } ?>
    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute'=>'idpacientes',
                'label'=>'Cédula del paciente',
                'value'=> $model->idpacientes0->identificacion,
            ],
            [
                'attribute'=>'fecha_atencion',
                'value'=>isset($model->fecha_atencion) ? Yii::$app->formatter->asDate($model->fecha_atencion, 'long') : '',
            ],
            'autorizacion',
            'numero_muestra',
            [
                'attribute'=>'valor_procedimiento',
                'value'=>'$'.number_format($model->valor_procedimiento),
            ],
            [
                'attribute'=>'eps_ideps',
                'label'=>'EPS',
                'value'=> $model->epsIdeps->nombre,
            ],
            'cod_cups',
            'cantidad_muestras',
            [
                'attribute'=>'valor_copago',
                'value'=>'$'.number_format($model->valor_copago),
            ],
            [
                'attribute'=>'valor_saldo',
                'value'=>'$'.number_format($model->valor_saldo),
            ],
            [
                'attribute'=>'valor_abono',
                'value'=>'$'.number_format($model->valor_abono),
            ],
            [
                'attribute',
                'label'=>'Médico remitente',
                'value'=>$model->medico == null ? '' : $model->medico0->nombre,
            ],
            [
                'attribute'=>'observaciones',
                'value'=>isset($model->observaciones) ? $model->observaciones : '',
            ],
            [
                'attribute'=>'forma_pago',
                'value'=>isset($model->forma_pago) ? ListasSistema::find()->select('descripcion')->where(['codigo'=>$model->forma_pago])->scalar() : '',
            ],
            [
                'attribute'=>'numero_cheque',
                'value'=>isset($model->numero_cheque) ? $model->numero_cheque : '',
            ],
            [
                'attribute'=>'estado',
                'value'=>isset($model->estado) ? ListasSistema::find()->select('descripcion')->where(['codigo'=>$model->estado])->scalar() : '',
            ],
            
            [
                'attribute'=>'fecha_informe',
                'value'=>isset($model->fecha_informe) ? Yii::$app->formatter->asDate($model->fecha_informe, 'long') : '',
            ],
            'numero_factura',
            [
                'attribute'=>'fecha_salida',
                'value'=>isset($model->fecha_salida) ? Yii::$app->formatter->asDate($model->fecha_salida, 'long') : '',
            ],
            [
                'attribute'=>'fecha_entrega',
                'value'=>isset($model->fecha_entrega) ? Yii::$app->formatter->asDate($model->fecha_entrega, 'long') : '',
            ],
            [
                'attribute'=>'periodo_facturacion',
                'value'=>isset($model->periodo_facturacion) ? Yii::$app->formatter->asDate($model->periodo_facturacion, 'long') : '',
            ],
            [
                'attribute'=>'idtipo_servicio',
                'label'=>'Estudio',
                'value'=> $model->idtipoServicio->nombre,
            ],
            [
                'attribute'=>'idmedico',
                'label'=>'Médico',
                'value'=> $model->nombreMedico != null ? $model->nombreMedico : '',
            ],
            [
                'attribute'=>'usuario_recibe',
                'label'=>'Usurio recibe',
                'value'=> $model->usuarioRecibe->nombre,
            ],
            [
                'attribute'=>'usuario_transcribe',
                'label'=>'Usurio transcribe',
                'value'=> $model->nombreUsuarioTrasncribe,
            ],
            [
                'attribute'=>'descuento',
                'value'=>number_format($model->descuento).'%',
            ],
            
        ],
    ]) ?>

</div>
