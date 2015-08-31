<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecibosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recibos';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="recibos-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-12">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
            </div>
            <div class="col-md-12 fomularioTitulo">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
        <?php  if(isset($dataProvider)) echo Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>'num_muestra',
                'label'=>'Procedimiento',
                'value'=>'idprocedimiento0.numero_muestra',
            ],
            
            'num_recibo',
            [
                'attribute'=>'valor_saldo',
                'value'=>function($model){
                    return '$'.number_format($model->valor_saldo);
                },
            ],
            [
                'attribute'=>'valor_abono',
                'value'=>function($model){
                    return '$'.number_format($model->valor_abono);
                },
            ],
            
            [
                'attribute'=>'nombre_usuario',
                'label'=>'Usuario',
                'value'=>'idusuario0.nombre',
            ],
            
            [
                'attribute'=>'fecha',
                'value'=>function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'd-MMM-yyyy');
                },
                'filter' => yii\jui\DatePicker::widget(['name' => 'Recibos[fecha]',"dateFormat" => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                'format' => 'html',
            ],

            

            // ['class' => 'yii\grid\ActionColumn'],
        ],
        'toolbar' => [
            // ['content'=>
            //     Html::a('Crear procedimiento', ['create'], ['class' => 'btn btn-success'])
            // ],
            '{export}',
            // '{toggleData}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>

</div>
