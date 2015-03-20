<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::a('Crear médico', ['create'], ['style'=>'float:right', 'class' => 'btn btn-success btn-lg']);?>
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

                'ips_idips',
                'idespecialidades',
                'codigo',
                'nombre',
                // 'id',
                // 'idclientes',
                // 'ruta_firma',

                // ['class' => 'yii\grid\ActionColumn'],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template'=>'{update} {delete}'
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
                'heading' => '<i class="glyphicon glyphicon-user"></i>  Médicos',
            ],
            'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
        ]); ?>
    <?php } ?>

</div>
<?php Modal::begin([
    'id'=>'viewModal',
    'header'=>'<h3>Actualizar</h3>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>['data-backdrop'=>'static'],
]);  
echo "<div id='vista'></div>";
Modal::end();
?>

<script type="text/javascript">
    $(document).on('click', '#medicos tr',function(event) {
        event.preventDefault();
        openModalView('vista',$(this));
    });
    
    $(document).on('click','#actualizar', function(event) {
        event.preventDefault();
            $('#viewModal').modal({backdrop:'static'})
            .find('#vista')
            .load($(this).attr('value'));
    });
</script>
