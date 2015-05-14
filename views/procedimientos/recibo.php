  <?php 
use kartik\grid\GridView;
use yii\helpers\Html;
   ?>

<h3>Recibos del estudio <span><?=$model->numero_muestra?></span></h3>
  <?= GridView::widget([
        'id'=>'recibos',
        'dataProvider' => $recibos,
        // 'filterModel' => $searchModel,
        'columns' => [
           
            // 'idprocedimiento',
            'num_recibo',
            'valor_abono',
            'valor_saldo',
            [
                'label'=>'',
                'value'=>function($model){
                    return Html::a('Imprimir', ['generar-recibo', 'id'=>$model->id, 'vista'=>2], ['target'=>'_blank','class' => '']);
                },
                'format'=>'raw',
            ]
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
        ],
        'exportConfig' => [GridView::CSV => ['label' => 'Save as CSV']],
    ]); ?>