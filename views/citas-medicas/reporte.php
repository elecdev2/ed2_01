 <?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\grid\GridView;
use kartik\grid\GridView;

use app\models\ListasSistema;
use app\models\Medicos;
use app\models\UsuariosIps;

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
        // 'pjax'=>true,
        'columns' => [
            // 'id_citas',

            [
                'label'=>'',
                'value'=>function($model){
                    $cadena = ListasSistema::find()->select(['descripcion'])->where(['tipo'=>"cita_estado", 'codigo'=>$model->estado])->scalar();
                    $color = substr($cadena, 0, 7);
                    return '<span class="badge" style="padding: 10px; background-color:'.$color.'"> </span>';
                },
                'vAlign'=>'middle',
                'format'=>'raw',
            ],
            [
                'attribute'=>'medicos_id',
                'label'=>'Médico',
                'filter'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>(UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]))])->all(),'id', 'nombre'),
                'value'=> 'medicos.nombre',
                'format'=>'raw',
            ],
            // [
            //     'attribute'=>'medico',
            //     'filter'=>ArrayHelper::map(Medicos::find()->where(['ips_idips'=>(UsuariosIps::find()->select(['idips'])->where(['idusuario'=>Yii::$app->user->id]))])->all(),'id', 'nombre'),
            //     'label'=>'Médico',
            //     'value'=> 'medicos.nombre',
            //     'format'=>'raw',
            // ],
            [
                'attribute'=>'motivo',
                'value'=>'tipoServicio.nombre'
            ],
            [
                'attribute'=>'id_pac',
                'label'=>'ID Paciente',
                'value'=> 'pacientes.identificacion',
            ],
            [
                'attribute'=>'nombre1',
                'label'=>'Primer nombre',
                'value'=> 'pacientes.nombre1',
            ],
            [
                'attribute'=>'nombre2',
                'label'=>'Segundo nombre',
                'value'=> 'pacientes.nombre2',
            ],
            [
                'attribute'=>'apellido1',
                'label'=>'Primer apellido',
                'value'=> 'pacientes.apellido1',
            ],
            [
                'attribute'=>'apellido2',
                'label'=>'Segundo apellido',
                'value'=> 'pacientes.apellido2',
            ],
           
            [
                'attribute'=>'fecha',
                'value'=>function($model){
                    return Yii::$app->formatter->asDate($model->fecha, 'd-MMM-yyyy');
                },
                // 'hAlign'=>GridView::ALIGN_RIGHT,
                'filterType'=>'\yii\jui\DatePicker',
                'filterWidgetOptions'=>['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true']],
                // 'filter' => yii\jui\DatePicker::widget(['name' => 'CitasMedicasSearch[fecha]', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']),
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
              
                'filter'=>ArrayHelper::map(ListasSistema::find()->select(['codigo', 'descripcion'=>'SUBSTRING(descripcion, 8)'])->where(['tipo'=>'cita_estado'])->all(),'codigo','descripcion'),
             
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

<div id="viewModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div id='vista'></div>
            </div>
        </div>
    </div>
</div>


