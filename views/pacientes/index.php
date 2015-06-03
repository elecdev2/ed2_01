<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pacientes-index">

    <!-- <div class="text-center"><?php //echo Html::tag('h3', (isset($_GET['message'])) ? $_GET['message'] : '' ,['class'=> 'help-block']);?></div> -->
    <div class="panel panel-default">
        <div class="panel-body">
             <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-6">
                    <?= Html::a('<i class="add icon-add"></i>Crear paciente', ['create'], ['class' => 'btn btn-success crear']);?>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel,'lista_tipoid'=>$lista_tipoid]); ?>
            </div>
        </div>
        <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>

    <?= GridView::widget([
        'id'=>'pacientes',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'rowOptions' => ['class' => 'text-center'],
        'pjax'=>true,
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

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view}{update}',
                'buttons' => [
                    'view'=> function ($url, $model, $key) {
                        return '<a href="" id="ver" class="vi" title="Ver"></a>';
                    },
                    'update'=> function ($url, $model, $key) {
                        return '<a href="" id="actualizar" class="up" title="actualizar"></a>';
                    },
                ],
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
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>
</div>


<?=$this->render('//site/modals'); ?>

<script type="text/javascript">
    $(document).on('click', '#pacientes tr td:not(#pacientes tr td.skip-export)',function(event) {
        event.preventDefault();
        openModalView('vista',$(this).parent());
    });


</script>