<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Médicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h1 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-sm-6">
                <?= Html::a('Crear médico', ['create'], ['class' => 'crear add']);?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_search', ['model' => $searchModel, 'lista_especialidades'=>$lista_especialidades]); ?>
        </div>
    </div>
    
    <?php if(isset($dataProvider)){ ?>
        <?= GridView::widget([
            'id'=>'medicos',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute'=>'ips',
                    'label'=>'IPS',
                    'value'=> 'ipsIdips.nombre',
                ],
                // 'ips_idips',
                [
                    'attribute'=>'especialidad',
                    'label'=>'Especialidad',
                    'value'=> 'idespecialidades0.nombre',
                ],
                // 'idespecialidades',
                'codigo',
                'nombre',
                // 'id',
                // 'idclientes',
                // 'ruta_firma',

                // ['class' => 'yii\grid\ActionColumn'],
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
    <?php } ?>

</div>

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
    $(document).on('click', '#medicos tr td:not(#medicos tr td.skip-export)',function(event) {
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
</script>
