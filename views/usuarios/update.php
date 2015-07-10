<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Medicos;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>

    <div class="col-sm-4">
        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Foto</h3>
            </div>
            <div class="panel-body" style="padding:10px;">
                <img class="img-rounded img-responsive" src="<?=Yii::$app->request->baseUrl?>/images/fotos_perfiles/<?=$model->foto?>" alt="<?=$model->nombre?>">
                <div style="float:right;position:relative;">
                    <?= Html::a('', [''], ['id'=>'cambiarFoto', 'title'=>'Cambiar foto', 'class' => 'up']) ?>
                    <?php if($model->foto != 'MDMasAvatar.png' && $model->foto != 'MDFemAvatar.png' && $model->foto != 'SecretariaAvatar.png' && $model->foto != 'UsuarioAvatar.png'){ ?>
                        <?= Html::a('', ['borrar-foto','id'=>$model->id], ['title'=>'Eliminar foto', 'class' => 'del','data' => [
                                'confirm' => '¿Está seguro que desea eliminar esta foto?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Formulario oculto: revisar library.js y buscar los id de los input y el boton -->
    <div style="display:none">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data',  'name' => 'formulario1'], 'action' => 'upload']) ?>
                <?= $form->field($imagen, 'file')->fileInput(['id'=>'input-1']) ?>
                <!-- <input id="input-1" required name="UploadFormImages[file]" type="file" class="file filestyle" data-buttonName="btn-primary" data-buttonText="Examinar"> -->
                <input hidden id="iu" type="text" name="usuario" value="<?=$model->id;?>">
                <button id="cargar" type="submit" class="btn btn-success" name="submit">Cargar Imagen</button>
        <?php ActiveForm::end() ?>
    </div>

    <div class="usuarios-update col-sm-8">
    <input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
        <div class="panelFormulario-contenido">
            <div class="panelFormulario-header">
                <h3 class="titulo-tarifa">Perfil</h3>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'id_cliente'=>$id_cliente,
                    'lista_perf'=>$lista_perf,
                    'lista_ips'=>$lista_ips,
                    'lista_especialidades'=>$lista_especialidades,
                    'ipsModel'=>$ipsModel,
                ]) ?>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        if($('#usuarios-perfil').val() == 'medico')
        {
            $('#campoIPSs').hide();
        }
    });
</script>