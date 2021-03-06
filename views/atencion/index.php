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

$this->title = 'Consultas';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Nuevo procedimiento', ['create'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel, 'lista_estados'=>$lista_estados]); ?>
            </div>
        </div>
        <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>

    
    <div class="promotores-view">
            <?= GridView::widget([
                'id'=>'atencion',
                'dataProvider' => $dataProvider,
                'headerRowOptions'=>['class'=>'cabecera'],
                'filterModel' => $searchModel,
                'pjax'=>true,
                'pjaxSettings'=>[
                    'neverTimeout'=>true,
                    'options'=>[
                        'id'=>'atn_pjax',
                    ]
                ],
                'columns' => [
                    [
                        'attribute'=>'fecha_atencion',
                        'value'=>function($model){
                            return Yii::$app->formatter->asDate($model->fecha_atencion, 'd-MMM-yyyy');
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
                        'filterType'=>'\yii\jui\DatePicker',
                        'filterWidgetOptions'=>['id'=>'f_atencion', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true']],
                        // 'filter' => yii\jui\DatePicker::widget(['id'=>'procedimientossearch-fecha_atencion', 'name' => 'ProcedimientosSearch[fecha_atencion]', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                        'format' => 'html',
                    ],
                    [
                        'attribute'=>'hora',
                        'value'=>function($model){
                            return date('h:i a', strtotime($model->hora));
                        }
                    ],
                    [
                        'attribute'=>'tipo_servicio',
                        'label'=>'Motivo',
                        'value'=>'idtipoServicio.nombre',
                    ],
                    
                    // [
                    //     'attribute'=>'numero_muestra',
                    //     'label'=>'N° muestra',
                    //     'hAlign'=>GridView::ALIGN_CENTER,                     
                    // ],

                    [
                        'attribute'=>'eps',
                        'label'=>'EPS',
                        'value'=> 'epsIdeps.nombre',
                    ],

                    [
                        'attribute'=>'paciente',
                        'label'=>'Paciente',
                        'value'=> function($model){
                            return $model->idpacientes0->nombre1.' '.$model->idpacientes0->nombre2.' '.$model->idpacientes0->apellido1.' '.$model->idpacientes0->apellido2;
                        },
                    ],

                    [
                        'attribute'=>'numid_paciente',
                        'label'=>'ID paciente',
                        'value'=> 'idpacientes0.identificacion',
                    ],
                  
                 
                    // 'valor_procedimiento',
                    // 'numero_factura',
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
                   
                    [
                        'attribute' => 'estado',
                        'filter'=>ArrayHelper::map(ListasSistema::find()->where('tipo="estado_atencion"')->all(),'codigo','descripcion'),
                        'value'=>function($model){
                            return ListasSistema::find()->select(['descripcion'])->where(['tipo'=>"estado_atencion", 'codigo'=>$model->estado])->scalar();
                        },
                        'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Seleccione un estado'],
                        'hAlign'=>GridView::ALIGN_CENTER,  
                    ],
                    // 'fecha_salida',
                    // 'fecha_entrega',
                    // 'periodo_facturacion',
                    // 'idmedico',
                    // 'usuario_recibe',
                    // 'usuario_transcribe',
                    // 'descuento',

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{view}{update}',
                        'buttons' => [
                            'view'=> function ($url, $model, $key) {
                                return '<a href="" id="ver" class="vi" title="Ver"></a>';
                            },
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
    </div>
</div>


<?=$this->render('//site/modals'); ?>

<div id="historiaModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" onclick="swichtWIndow(historiaModal,viewModal)"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="titulo-tarifa">Historia clínica</h3>
            </div>
            <div class="modal-body">
                <div id='historia'></div>
            </div>
        </div>
    </div>
</div>