<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlantillasDiagnosticosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plantillas Diagnosticos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantillas-diagnosticos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h1 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-sm-6">
                <?= Html::a('Plantilla nueva', ['create'], ['class' => 'crear add']);?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'titulo',
            'descripcion',
            // 'id_medico',

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
<?php Modal::begin([
    'id'=>'updateModal',
    'header'=>'<h3></h3>',
    // 'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='act'></div>";
Modal::end();
?>

<script type="text/javascript">
    $(document).on('click', '#actualizar' ,function(event) {
        event.preventDefault();
        openModalUpdate('act',$($(this).parent()).parent());
    });
</script>