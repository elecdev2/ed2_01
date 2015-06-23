<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */

$this->title = $model->id_citas;
$this->params['breadcrumbs'][] = ['label' => 'Citas Medicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-medicas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_citas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_citas], [
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
            'id_citas',
            'pacientes_id',
            'medicos_id',
            'fecha',
            'hora',
            'observaciones',
        ],
    ]) ?>

</div>
