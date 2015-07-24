<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IpsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ips';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Nueva IPS', ['create'], ['class' => 'btn btn-success crear']);?>
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
        'id'=>'ipsTab',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // 'id',
            'idclientes',
            'codigo',
            'nombre',
            'direccion',
            'tipo_identificacion',
            'nit',
            'telefono',
            'activo',
            // 'consecutivo_fact',
            // 'representante_legal',
            // 'consecutivo_recibo',
            // 'descripcion',
            // 'mensaje_email:email',

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
                        return Html::a('', ['delete', 'id' => $model->id], ['class' => 'del',
                            'data' => ['confirm' => '¿Está seguro que desea borrar este elemento?','method' => 'post',],
                        ]);
                    },
                   
                ],
                
            ],
        ],
        'toolbar' => [
            // ['content'=>
            //     Html::a('Crear ips', ['create'], ['class' => 'btn btn-success']),
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
