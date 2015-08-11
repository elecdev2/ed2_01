<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoriaClinicaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historia Clinica';
// $this->params['breadcrumbs'][] = $this->title;
?> 

<div class="historia-clinica-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-md-12">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title); ?></h2>
                </div>
            </div>
        
            <div class="col-md-12 fomularioTituloReporte">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>

        </div>
        <?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span>Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-botonReporte', 'data-value'=>$cerrar]);   ?>
    </div>

<?php if(isset($dataProvider)){ ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=>'historia_rep',
        'pjax'=>true,
        'columns' => [
            // 'id',
            [
                'class'=>'yii\grid\CheckboxColumn',
                // 'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
            [
                'attribute'=>'paciente',
                'label'=>'ID paciente',
                'value'=>'idPaciente.identificacion',
            ],
            [
                'attribute'=>'tipo_servicio',
                'label'=>'Motivo',
                'value'=>'idTipos.nombre',
            ],
            [
                'attribute'=>'medico',
                'label'=>'Médico',
                'value'=>'idMedico.nombre',
            ],
            [
                'attribute'=>'fecha',
                'value'=>function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'd-MMM-yyyy');
                },
                'hAlign'=>GridView::ALIGN_RIGHT,
                'filterType'=>'\yii\jui\DatePicker',
                'filterWidgetOptions'=>['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true']],
                'format' => 'html',
            ],
            [
                'attribute'=>'hora',
                'value'=>function($model){
                    return date('h:i:s a', strtotime($model->hora));
                }
            ],
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view}{update}',
                'buttons' => [
                    'view'=> function ($url, $model, $key) {
                        return '<a href="" onclick="openModalViewHistoria($($(this).parent()).parent())" class="vi" title="Ver"></a>';
                    },
                    'update'=> function ($url, $model, $key) {
                        return '<a href="" class="imp" onclick="imprimirHistoria($($(this).parent()).parent().attr(\'data-key\'))" title="imprimir"></a>';
                    },
                    // 'delete'=> function ($url, $model, $key) {
                    //     return Html::a('', ['delete', 'id' => $model->cod_cups], ['class' => 'del',
                    //         'data' => ['confirm' => '¿Está seguro que desea borrar este elemento?','method' => 'post',],
                    //     ]);
                    // },
                   
                ],
                
            ],
        ],
        'toolbar' => [
                [
                    'content'=>Html::a('<i class="add icon-imprimir"></i>Imprimir', ['#'], ['class' => 'imprimir btn btn-primary']),
                ],
                // '{export}',
            //     '{toggleData}',
            ],
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
            ],
            'exportConfig' => [GridView::PDF => ['label' => 'Guardar como PDF']],
    ]); ?>

<?php } ?>

</div>

<div id="viewHistoriaModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="titulo-tarifa">Historia clínica</h3>
            </div>
            <div class="modal-body">
                <div id='vista'></div>
            </div>
        </div>
    </div>
</div>