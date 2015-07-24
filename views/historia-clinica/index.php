<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoriaClinicaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historia Clinica';
// $this->params['breadcrumbs'][] = $this->title;
?> 

<div class="historia-clinica-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-md-12">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title); ?></h2>
                </div>
            </div>
        
            <div class="col-md-12 fomularioTituloReporte">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>

        </div>
        <?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span>Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-botonReporte', 'data-value'=>$cerrar]);   ?>
    </div>

<?php if(isset($dataProvider)){ ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'id_paciente',
            'id_tipos',
            'id_medico',
            'fecha',
            'hora',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'toolbar' => [
            //     ['content'=>
            //         Html::a('Crear cliente', ['create'], ['class' => 'btn btn-success']),
            //     ],
                // '{export}',
            //     '{toggleData}',
            ],
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
            ],
            'exportConfig' => [GridView::PDF => ['label' => 'Guardar como PDF']],
    ]); ?>

<?php } ?>

</div>
