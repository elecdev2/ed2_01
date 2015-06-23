<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre.' - '.$model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

    <div class="col-sm-4">
        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Foto</h3>
            </div>
            <div class="panel-body" style="padding:15px;">
                <img class="img-rounded img-responsive" src="<?=Yii::$app->request->baseUrl?>/images/fotos_perfiles/<?=$model->foto?>" alt="<?=$model->nombre?>">
            </div>
        </div>
    </div>

    <div class="usuarios-view col-sm-8">

    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    
        <div class="panelFormulario-contenido">
             <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Perfil</h3>
            </div>
            <div class="panel-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        // 'id',
                        [
                            'attribute'=>'idmedicos',
                            'label'=>'Es usuario médico?',
                            'value'=>$model->idmedicos == null ? 'No' : 'Si',
                        ],
                        // 'idmedicos',
                        // 'password',
                        'nombre',
                        'sexo',
                        // 'idclientes',
                        'username',
                        [
                            'attribute'=>'activo',
                            'value'=>$model->activo == 1 ? 'Si' : 'No',
                        ],
                        // 'activo',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

