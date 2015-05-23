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
            <?php  if(isset($dataProvider)) echo Html::a('[+] Nueva Consulta','#',['class'=>'search-boton']);   ?><br>
            <?= $this->render('_search', ['model' => $searchModel, 'lista_estados'=>$lista_estados]); ?>
        </div>
    </div>
    
    <div class="promotores-view">
            <?= GridView::widget([
                'id'=>'procedimientos',
                'dataProvider' => $dataProvider,
                'headerRowOptions'=>['class'=>'text-center'],
                'filterModel' => $searchModel,
                // 'pjax'=>true,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    
                    [
                        'attribute'=>'fecha_atencion',
                        'value'=>function($model){
                            Yii::$app->timeZone = 'America/Bogota';
                            Yii::$app->formatter->locale = 'es-ES';
                            return Yii::$app->formatter->asDate($model->fecha_atencion, 'd-MMM-yyyy');
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
                        'filter' => yii\jui\DatePicker::widget(["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                        'format' => 'raw',
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
                            Yii::$app->timeZone = 'America/Bogota';
                            Yii::$app->formatter->locale = 'es-ES';
                            return Yii::$app->formatter->asDate($model->fecha_salida, 'd-MMM-yyyy');
                        },
                        'hAlign'=>GridView::ALIGN_RIGHT,
                        'filter' => yii\jui\DatePicker::widget(["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
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
                        'filterInputOptions'=>['style'=>'height:34px', 'placeholder'=>'Seleccione un estado'],
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

   $(document).ready(function() {
        $('.procedimientos-search').hide();
        $('.search-boton').on('click', function() {
            $('.procedimientos-search').slideToggle('fast');
            $('.search-boton').html() == '[-] Ocultar' ? $('.search-boton').html('[+] Nueva Consulta') : $('.search-boton').html('[-] Ocultar');
            return false;
        });
   });







    // $(document).on('click','#editarPerfil', function(event) {
    //     event.preventDefault();
    //         $('#viewModal').modal({backdrop:'static'})
    //         .find('#vista')
    //         .load($(this).attr('value'));
    // });
</script>
