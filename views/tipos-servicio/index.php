<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\Ips;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TiposServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Servicios';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-servicio-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Nuevo tipo de estudio', ['create'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel, 'ips_list'=>$ips_list,]); ?>
            </div>
        </div>
         <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>

    <?= GridView::widget([
        'id'=>'tipoServicioTab',
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'nombre',
            [
                'attribute'=>'idips',
                'value'=>function($model){
                    return Ips::find()->select(['nombre'])->where(['id'=>$model->idips])->scalar();
                },
            ],
            
            'consecutivo',
            'serie',

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
            //     Html::a('Crear tipo de servicio', ['create'], ['class' => 'btn btn-success']),
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
    $(document).on('click', '#tipoServicioTab tr td:not(#tipoServicioTab tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    });

    $(document).ready(function() {
        $('.fomularioTitulo').hide();
        $('.search-boton').on('click', function() {
            $('.fomularioTitulo').slideToggle('slow');
            return false;
        });
   });
</script>