<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-sm-6">
                <?= Html::a('Crear Usuario', ['create'], ['class' => 'crear add']);?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

<?php if(isset($dataProvider)){ ?>
    <?= GridView::widget([
        'id'=>'usuarios',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nombre',
            'username',
            // 'idmedicos',
            // 'idclientes',
            // 'activo',
            'perfil',
            [
                'attribute'=>'activo',
                'value'=>function($model){
                    return $model->activo == 1 ? 'Si' : 'No';
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
            //     Html::a('Crear usuario', ['create'], ['class' => 'btn btn-success']),
            // ],
            // '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-home"></i>  Usuarios',
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
    $(document).on('click', '#usuarios tr td:not(#usuarios tr td.skip-export)',function(event) {
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
