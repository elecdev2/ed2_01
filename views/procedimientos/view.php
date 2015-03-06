<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'idbackup',
        ],
    ]) ?>

</div>
