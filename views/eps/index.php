<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EpsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'EPS';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="eps-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Crear EPS', ['create'], ['class' => 'crear btn btn-success']);?>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
        <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>

    <?= Yii::$app->session->getFlash('error'); ?>

    <?= GridView::widget([
        'id'=>'eps',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>'ips',
                'label'=>'IPS',
                'value'=> 'idips0.nombre',
            ],
            // 'idips',
            'codigo',
            'nombre',
            'direccion',
            'telefono',
            'nit',
            [
                'attribute' => 'generar_rip',
                'value'=>function($model){
                    return $model->generar_rip == 1 ? 'Si' : 'No';
                },
                'filter'=>['1'=>'Si','2'=>'No'],
                'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Generar RIPs'],
            ],
            // 'generar_rip',
            // 'idinformes',
            [
                'attribute' => 'activo',
                'value'=>function($model){
                  return $model->activo == 1 ? 'Si' : 'No';
                },
                'filter'=>['1'=>'Si','2'=>'No'],
                'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Seleccione un estado'],
            ],
            // 'activo',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view} {update}  {tarifas}',
                'buttons' => [
                    'view'=> function ($url, $model, $key) {
                        return '<a href="" id="ver" class="vi" title="Ver"></a>';
                    },
                    'tarifas'=>function ($url, $model, $key) {
                        return Html::a('', ['tarifas/index', 'ideps' => $model->id], ['class' => 'ta', 'title'=>'Estudios']);
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
                'width'=>'120px',
            ],

        ],
        'toolbar' => [
            // ['content'=>
            //     Html::a('Crear Eps', ['create'], ['class' => 'btn btn-success']),
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

<?=$this->render('//site/modals'); ?>

<script type="text/javascript">
   
    $(document).on('click', '#eps tr td:not(#eps tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    });

</script>
