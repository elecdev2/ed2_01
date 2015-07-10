<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */

$this->title = $model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Medicos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>

<div class="col-sm-4">
    <div class="panelFormulario-contenido">
        <div class="panelFormulario-header">
            <h3 class="titulo-tarifa">Firma</h3>
        </div>
        <div class="panel-body" style="padding:10px;">
        	<?php if($model->ruta_firma != null){ ?>
            	<img class="img-rounded img-responsive" src="<?=Yii::$app->request->baseUrl?>/images/firmas/<?=$model->ruta_firma?>" alt="firma <?=$model->nombre?>">
            <?php } ?>

            <div style="float:right;position:relative;">
                <?= Html::a('', [''], ['id'=>'cambiarFoto', 'title'=>'Cambiar firma', 'class' => 'up']) ?>

	            <?php if($model->ruta_firma != null){ ?>
	                <?= Html::a('', ['borrar-foto','id'=>$model->id], ['title'=>'Eliminar firma', 'class' => 'del','data' => [
	                        'confirm' => '¿Está seguro que desea eliminar esta firma?',
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
            <input hidden id="iu" type="text" name="medico" value="<?=$model->id;?>">
            <button id="cargar" type="submit" class="btn btn-success" name="submit">Cargar Imagen</button>
    <?php ActiveForm::end() ?>
</div>

<div class="medicos-update col-sm-8">
<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <div class="panelFormulario-contenido">
    	<div class="panelFormulario-header">
            <h3 class="titulo-tarifa">Perfil médico</h3>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
                'lista_especialidades'=>$lista_especialidades,
                'lista_ips'=>$lista_ips,
                'lista_colores'=>$lista_colores,
            ]) ?>
        </div>
    </div>
</div>


