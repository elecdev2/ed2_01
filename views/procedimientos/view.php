<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->numero_muestra;
$this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-view">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-6">
                <?= Html::button(
                'Actualizar',
                ['value' => Url::to(['procedimientos/update?id='.$model->id]),
                    'id' => 'actualizar',
                    'class'=>'btn btn-primary btn-lg',
                    'style'=>'float:right',
         
                ]) ?>
                <!-- <button id="actualizar" class="btn btn-primary btn-lg"></button> -->
            </div>
        </div>
    </div>


 <!--    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'idpacientes',
            'fecha_atencion',
            'autorizacion',
            'numero_muestra',
            'valor_procedimiento',
            'eps_ideps',
            'cod_cups',
            'cantidad_muestras',
            'valor_copago',
            'valor_saldo',
            'valor_abono',
            'medico',
            'observaciones',
            'forma_pago',
            'numero_cheque',
            'estado',
            'fecha_informe',
            'numero_factura',
            'fecha_salida',
            'fecha_entrega',
            'periodo_facturacion',
            'idtipo_servicio',
            'idmedico',
            'usuario_recibe',
            'usuario_transcribe',
            'descuento',
        ],
    ]) ?>

</div>
