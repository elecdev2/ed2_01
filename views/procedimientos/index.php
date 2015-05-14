<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

// use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\Pacientes;
use app\models\Ips;
use app\models\ListasSistema;
use app\models\Procedimientos;
use yii\bootstrap\Modal;
use kartik\select2\Select2;



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
            <div class="col-sm-6">
                <h1 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-sm-6">
                <?= Html::a('Crear procedimiento', ['create'], ['class' => 'crear add']);?>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_search', ['model' => $searchModel, 'lista_estados'=>$lista_estados]); ?>
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

                    [
                        'attribute'=>'numero_muestra',
                        'label'=>'N° muestra',
                    ],
                    // 'numero_muestra',

                    [
                        'attribute'=>'eps',
                        'label'=>'EPS',
                        'value'=> 'epsIdeps.nombre',
                    ],
                    // 'eps_ideps',

                    [
                        'attribute'=>'numid_paciente',
                        'label'=>'CC paciente',
                        'value'=> 'idpacientes0.identificacion',
                    ],
                    // 'idpacientes',
                    'cod_cups',
                    [ 
                        'attribute'=>'valor_procedimiento',
                        'label'=>'$ estudio',
                    ],
                    // 'valor_procedimiento',
                    [ 
                        'attribute'=>'numero_factura',
                        'label'=>'N° factura',
                    ],
                    // 'numero_factura',
                    [
                        'attribute' => 'estado',
                        // 'vAlign'=>'middle',
                        // 'width'=>'180px',
                        // 'filterType'=>GridView::FILTER_SELECT2,
                        'filter'=>ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion'),
                        // 'filterWidgetOptions'=>[
                        //     'pluginOptions'=>['allowClear'=>true],
                        // ],
                        'filterInputOptions'=>['placeholder'=>'Seleccione un estado'],
                        // 'format'=>'raw'
                    ],
                    // 'estado',
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

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{update}',
                        'buttons' => [
                            'update'=> function ($url, $model, $key) {
                                return '<a href="" id="actualizar" class="up" title="actualizar"></a>';
                            },
                            // 'delete'=> function ($url, $model, $key) {
                            //     return Html::a('', ['delete', 'id' => $model->id], ['class' => 'del',
                            //         'data' => ['confirm' => '¿Está seguro que desea borrar este elemento?','method' => 'post',],
                            //     ]);
                            // },
                        ],
                        // 'width'=>'10%',
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
                <h4 class="modal-title"><h3></h3></h4>
            </div>
            <div class="modal-body">
                <div id="act"></div> 
            </div>
        </div>
    </div>
</div> -->

<?php Modal::begin([
    'id'=>'updateModal',
    'header'=>'<h3></h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='act'></div>";
Modal::end();
?>

<?php Modal::begin([
    'id'=>'viewModal',
    'header'=>'<h3></h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='vista'></div>";
Modal::end();
?>



<script type="text/javascript">
    $(document).on('click', '#procedimientos tr td:not(#procedimientos tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    });

    $(document).on('click', '#actualizar' ,function(event) {
        event.preventDefault();
        openModalUpdate('act',$($(this).parent()).parent());
    });
   
    
    $(document).on('click','.updModal', function(event) {
        event.preventDefault();
            $('#viewModal').modal({backdrop:'static'})
            .find('#vista')
            .load($(this).attr('value'));
    });


    // $(document).on('click','#editarPerfil', function(event) {
    //     event.preventDefault();
    //         $('#viewModal').modal({backdrop:'static'})
    //         .find('#vista')
    //         .load($(this).attr('value'));
    // });
</script>
