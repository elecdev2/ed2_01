<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlantillasDiagnosticosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plantillas diagnosticos';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantillas-diagnosticos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloCrear col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Plantilla nueva', ['create'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'id'=>'plantillaTab',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // 'id',
            'titulo',
            'descripcion',
            // 'id_medico',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
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
                'width'=>'10%',
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

<?=$this->render('//site/modals');  ?>

<script type="text/javascript">
    $(document).on('click', '#plantillaTab tr td:not(#plantillaTab tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    });

</script>