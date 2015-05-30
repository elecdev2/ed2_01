<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TarifasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarifas'.' - '.$eps;
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarifas-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Nueva tarifa', ['create'], ['id'=>'tar','class' => 'crear btn btn-success tarifa']);?>
                    <?= Html::a('<i class="add icon-back"></i>Regresar', ['eps/index'], ['class' => 'btn btn-success crear', 'style'=>'margin-right:10px;']);?>
                    <!-- <a href="" onclick="goBack()" style="vertical-align: middle;" title="Volver"><i class="glyphicon glyphicon-chevron-left"></i></a>  -->
                </div>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'id'=>'tarifasTab',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'eps_id',
            [
                'attribute'=>'estudio',
                'label'=>'Estudios',
                'value'=> 'idestudios0.descripcion',
            ],
            [
                'attribute'=>'valor_procedimiento',
                'value'=>function($model){
                    return '$'.number_format($model->valor_procedimiento);
                },
            ],
            [
                'attribute'=>'descuento',
                'value'=>function($model){
                    return number_format($model->descuento).'%';
                },
            ],
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons' => [
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


<div id="tarModal" class="modal fade bs-example-modal-lg" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt=""></button>
                <h3 class="titulo-tarifa">Nueva tarifa</h3>
            </div>
            <div class="modal-body">
               <div id='tarifas'></div>
            </div>
        </div>
    </div>
</div>

<?=$this->render('//site/modals');  ?>

<script type="text/javascript">

     $(document).on('click', '#tar' ,function(event) {
        event.preventDefault();
        openModalTarifas('tarifas','<?=$ideps;?>');
    });


</script>

