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
            <div class="col-sm-7" style="padding-left:0;">
                <h2 class="titulo"><a href="" onclick="goBack()" style="vertical-align: middle;" title="Volver"><i class="glyphicon glyphicon-chevron-left"></i></a> <?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-sm-5">
                 <?= Html::button(
                'Crear tarifa',
                ['value' => Url::to(['tarifas/create?ideps='.$ideps]),
                    'id'=>'tar',
                    'class'=>'crear add tarifa',
                    'style'=>'float:right',
         
                ]) ?>

                <!-- <?php //echo Html::a('Crear Tarifa', ['create'], ['class' => 'crear add']);?> -->
            </div>
        </div>
    </div>

    <?= GridView::widget([
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
            // 'idestudios',
            'valor_procedimiento',
            'descuento',

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
                'heading' => '<i class="glyphicon glyphicon-list-alt"></i>  Tarifas',
            ],
            'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>

<?php Modal::begin([
    'id'=>'tarModal',
    'header'=>'<h3></h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='tarifas'></div>";
Modal::end();
?>

<?php Modal::begin([
    'id'=>'updateModal',
    'header'=>'<h3></h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='act'></div>";
Modal::end();
?>

<script type="text/javascript">
     $(document).on('click', '#tar' ,function(event) {
        event.preventDefault();
        openModalTarifas('tarifas','<?=$ideps;?>','create');
    });

     $(document).on('click', '#actualizar' ,function(event) {
        event.preventDefault();
        openModalUpdate('act',$($(this).parent()).parent());
    });

    function goBack() {window.history.back()};
</script>

