<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-index">

    <!-- <div class="text-center"><?php //echo Html::tag('h3', (isset($_GET['message'])) ? $_GET['message'] : '' ,['class'=> 'help-block']);?></div> -->
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::a('Crear paciente', ['create'], ['style'=>'float:right', 'class' => 'btn btn-success btn-lg']);?>
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
        'id'=>'pacientes',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'rowOptions' => ['class' => 'text-center'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'tipo_identificacion',
            'identificacion',
            'nombre1',
            'nombre2',
            'apellido1',
            'apellido2',
            // 'direccion',
            // 'telefono',
            // 'sexo',
            // 'fecha_nacimiento',
            // 'tipo_usuario',
            // 'tipo_residencia',
            // 'idclientes',
            // 'activo',
            // 'idciudad',
            // 'ideps',
            // 'email:email',
            // 'envia_email:email',
            // 'codeps',

            // ['class' => 'kartik\grid\ActionColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{update} {delete}'
            ],
        ],
        'toolbar' => [
        //     ['content'=>
        //         Html::a('Crear paciente', ['create'], ['class' => 'btn btn-success'])
        //     ],
        //     // '{export}',
        //     // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-user"></i>  Pacientes',
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
    $(document).on('click', '#pacientes tr',function(event) {
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