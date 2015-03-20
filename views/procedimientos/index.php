<?php

use yii\helpers\Html;

// use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\Pacientes;
use app\models\Ips;
use app\models\Procedimientos;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-index">

    <!-- <div class="text-center"><?php //echo Html::tag('h3', (isset($_GET['message'])) ? $_GET['message'] : '' ,['class'=> 'help-block']);?></div> -->
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

<!-- <div id="updateModal" class="modal fade bs-example-modal-lg" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title"><h3>Actualizar</h3></h4>
            </div>
            <div class="modal-body">
              
                <div id="act"></div>
            </div>
            <div class="modal-footer">
                <button id="gastoProm" type="button" class="btn btn-primary" >Guardar cambios</button> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div> -->

<?php Modal::begin([
    'id'=>'viewModal',
    'header'=>'<h3>Actualizar</h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='vista'></div>";
Modal::end();
?>


<script type="text/javascript">
    $(document).on('click', '#procedimientos tr',function(event) {
        event.preventDefault();
        openModalView('vista',$(this));
    });

    // listen click, open modal and .load content
    // $('#actualizar').click(function (){
    // // $(document).on('click','#actualizar', function(event) {
    //     // event.preventDefault();
    //     $('#viewModal').modal('hide');
    //     $('#updateModal').modal('show')
    //         .find('#act')
    //         .load($(this).attr('value'));
    // });
    
    $(document).on('click','#actualizar', function(event) {
        event.preventDefault();
            $('#viewModal').modal({backdrop:'static'})
            .find('#vista')
            .load($(this).attr('value'));
    });
</script>
