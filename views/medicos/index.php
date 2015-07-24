<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Médicos';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-12">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel, 'lista_especialidades'=>$lista_especialidades]); ?>
            </div>
        </div>
         <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>
    
        <?= GridView::widget([
            'id'=>'medicos',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'pjaxSettings'=>[
                'neverTimeout'=>true,
                'options'=>[
                    'id'=>'medicos_pjax',
                ]
            ],
            'columns' => [

                [
                    'attribute'=>'ips',
                    'label'=>'IPS',
                    'value'=> 'ipsIdips.nombre',
                ],
                [
                    'attribute'=>'especialidad',
                    'label'=>'Especialidad',
                    'value'=> 'idespecialidades0.nombre',
                ],
                'codigo',
                'nombre',
                // 'id',
                // 'idclientes',
                // 'ruta_firma',
                [
                    'attribute'=>'activo',
                    'value'=>function($model){
                        return $model->activo == 1 ? 'Si' : 'No';
                    },
                    'filter'=>['1'=>'Si','2'=>'No'],
                    'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Seleccione un estado'],
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template'=>'{view}{update}{delete}',
                    'buttons' => [
                        'view'=> function ($url, $model, $key) {
                            return '<a href="" id="ver" class="vi" title="Ver"></a>';
                        },
                        'update'=> function ($url, $model, $key) {
                            return '<a href="" id="actualizar" class="up" title="actualizar"></a>';
                        },
                        'delete'=> function ($url, $model, $key) {
                            return  Html::a('',['horario', 'id'=>$model->id],['id'=>'horario', 'class'=>'hr', 'title'=>'horario']);
                            // return '<a href="horario" id="horario" class="up" title="horario"></a>';
                        },
                       
                    ],
                ],

            ],
            'toolbar' => [
            //     ['content'=>
            //         Html::a('Crear médico', ['create'], ['class' => 'btn btn-success'])
            //     ],
            //     // '{export}',
            //     // '{toggleData}',
            ],
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
            ],
            'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
        ]); ?>

</div>

<?=$this->render('//site/modals'); ?>
