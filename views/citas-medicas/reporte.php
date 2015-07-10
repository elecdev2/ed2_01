 <?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\grid\GridView;
use kartik\grid\GridView;

use app\models\ListasSistema;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IpsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte de citas médicas';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ips-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloBoton col-md-12">
                <div class="col-sm-6">
                    <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
                </div>
            </div>
        </div>
    </div>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            // 'id_citas',
            [
                'attribute'=>'medico',
                'label'=>'Médico',
                'value'=> 'medicos.nombre',
            ],
            [
                'attribute'=>'id_pac',
                'label'=>'Paciente',
                'value'=> 'pacientes.identificacion',
            ],
           
            [
                'attribute'=>'fecha',
                'value'=>function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'd-MMM-yyyy');
                },
                // 'hAlign'=>GridView::ALIGN_RIGHT,
                'filter' => yii\jui\DatePicker::widget(['name' => 'CitasMedicas[fecha]', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
                'format' => 'html'
            ],
            [
                'attribute'=>'hora',
                'value'=>function($model){
                    return date('h:i a', strtotime($model->hora));
                },
                // 'hAlign'=>GridView::ALIGN_RIGHT,
                'format' => 'html'
            ],
            [
                'attribute' => 'estado',
              
                'filter'=>ArrayHelper::map(ListasSistema::find()->where('tipo="cita_estado"')->all(),'codigo','descripcion'),
             
                'value'=>function($model){
                    $cadena = ListasSistema::find()->select(['descripcion'])->where(['tipo'=>"cita_estado", 'codigo'=>$model->estado])->scalar();
                    $fin_cadena = strlen($cadena);
                    return substr($cadena, 7, $fin_cadena);
                },
                'filterInputOptions'=>['class'=>'filtro-opciones', 'placeholder'=>'Seleccione un estado'],
                'hAlign'=>GridView::ALIGN_CENTER,  
            ],
            // 'observacion',

            // ['class' => 'yii\grid\ActionColumn'],
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
    

</div>
<?=$this->render('//site/modals'); ?>

