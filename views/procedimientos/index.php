<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-index col-md-12">

    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::a('Crear procedimiento', ['create'], ['style'=>'float:right', 'class' => 'btn btn-success btn-lg']);?>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    
    <div class="promotores-view">
        <?php if(isset($dataProvider)){ ?>
            <?= GridView::widget([
                'id'=>'procedimientos',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'fecha_atencion',
                    'numero_muestra',
                    'eps_ideps',
                    'idpacientes',
                    'cod_cups',
                    'valor_procedimiento',
                    'numero_factura',
                    'estado',
                    // 'autorizacion',
                    // 'cantidad_muestras',
                    // 'valor_copago',
                    // 'valor_saldo',
                    // 'valor_abono',
                    // 'medico',
                    // 'observaciones',
                    // 'forma_pago',
                    // 'numero_cheque',
                    // 'fecha_informe',
                    // 'fecha_salida',
                    // 'fecha_entrega',
                    // 'periodo_facturacion',
                    // 'idtipo_servicio',
                    // 'idmedico',
                    // 'usuario_recibe',
                    // 'usuario_transcribe',
                    // 'descuento',
                    // 'idbackup',

                    // ['class' => 'kartik\grid\ActionColumn'],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{update} {delete}'
                    ],
                ],
                'toolbar' => [
                    // ['content'=>
                    //     Html::a('Crear procedimiento', ['create'], ['class' => 'btn btn-success'])
                    // ],
                    // '{export}',
                    // '{toggleData}',
                ],
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => '<i class="glyphicon glyphicon-list-alt"></i>  Procedimientos',
                ],
                'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
            ]); ?>
        <?php } ?>
    </div>
</div>

<div id="viewModal" class="modal fade bs-example-modal-lg act" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><h2>Información</h2></h4>
            </div>
            <div class="modal-body">
                <div id="vista"></div>
            </div>
            <div class="modal-footer">
                <!-- <button id="gastoProm" type="button" class="btn btn-primary" >Guardar cambios</button> --> 
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '#procedimientos tr',function(event) {
        event.preventDefault();
        fila = $(this).attr('data-key');
        $('#viewModal').modal({backdrop:'static'});
        $.get('view', {id: fila}).done(function(data) {
            $('#vista').html(data);
        });
    });
</script>
