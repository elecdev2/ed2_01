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
                    <?= Html::a('<i class="add icon-add"></i>Crear procedimiento', ['create'], ['class' => 'btn btn-success crear']);?>
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
                'id'=>'procedimientos',
                'dataProvider' => $dataProvider,
                // 'pjax'=>true,
                'headerRowOptions'=>['class'=>'cabecera'],
                'filterModel' => $searchModel,
                // 'pjax'=>true,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    
                    [
                        'attribute'=>'fecha_atencion',
                        'value'=>function($model){
                            // Yii::$app->formatter->locale = 'es-ES';
                            return Yii::$app->formatter->asDate($model->fecha_atencion, 'd-MMM-yyyy');
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
                        'filter' => yii\jui\DatePicker::widget(['name' => 'ProcedimientosSearch[fecha_atencion]', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                        'format' => 'html',
                    ],

                    [
                        'attribute'=>'numero_muestra',
                        'label'=>'N° muestra',
                        'hAlign'=>GridView::ALIGN_CENTER,                     
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
                        'label'=>'ID paciente',
                        'value'=> 'idpacientes0.identificacion',
                    ],
                    // 'idpacientes',
                    [
                        'attribute'=>'cod_cups',
                        'hAlign'=>GridView::ALIGN_CENTER,
                    ],
                    // 'cod_cups',
                    [ 
                        'attribute'=>'valor_procedimiento',
                        'label'=>'Valor estudio',
                        'value'=>function($model){
                            return '$'.number_format($model->valor_procedimiento);
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
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
                        'attribute'=>'fecha_salida',
                        'value'=>function($model){
                            return Yii::$app->formatter->asDate($model->fecha_salida, 'd-MMM-yyyy');
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
                        'filter' => yii\jui\DatePicker::widget(['name' => 'ProcedimientosSearch[fecha_salida]',"dateFormat" => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'estado',
                        // 'vAlign'=>'middle',
                        // 'width'=>'180px',
                        // 'filterType'=>GridView::FILTER_SELECT2,
                        'filter'=>ArrayHelper::map(ListasSistema::find()->where('tipo="estado_prc"')->all(),'codigo','descripcion'),
                        // 'filterWidgetOptions'=>[
                        //     'pluginOptions'=>['allowClear'=>true],
                        // ],
                        'value'=>function($model){
                            return ListasSistema::find()->select(['descripcion'])->where(['tipo'=>"estado_prc", 'codigo'=>$model->estado])->scalar();
                        },
                        'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Seleccione un estado'],
                        // 'format'=>'raw'
                        'hAlign'=>GridView::ALIGN_CENTER,  
                    ],
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


<script type="text/javascript">

// abrir ventana ver haciendo click en la fila
    $(document).on('click', '#procedimientos tr td:not(#procedimientos tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    }); 

// Modal del plantillas
    $(document).on('click','.plantillas', function(event) {
        event.preventDefault();
        $('#addDesc').attr('data-value', event.target.id);
        $('#plantillaModal').modal();
    });

    $(document).on('click','.plantillasNuevas', function(event) {
        event.preventDefault();
        $('#descripcionNuevo').val($('#vlrscamposprocedimientos-'+event.target.id+'-valor').val());
        $('#guardarPlantilla').attr('data-value', event.target.id);
        $('#plantillaNuevaModal').modal();
    });

</script>
