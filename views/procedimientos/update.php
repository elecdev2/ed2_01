<?php
use app\models\PlantillasDiagnosticos;
use app\models\Usuarios;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = $model->numero_muestra;
// $this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="procedimientos-update">

   <!--  <div class="panel panel-default">
        <div class="panel-body">
            <div class="">
                <h1 class="titulo tituloDetalle"><?//echo Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div> -->
<input type="text" hidden name="id_help" data-value="<?=$model->id?>" data-titulo="<?=Html::encode($this->title)?>" id="helperHid">
    <?= $this->render('_form', [
        'model' => $model,
        'paciente_model'=>$paciente_model,
        'ips_model'=>$ips_model,
        'ips_list'=>$ips_list,
        'lista_estados'=>$lista_estados,
        'lista_pago'=>$lista_pago,
        'lista_med'=>$lista_med,
        'lista_medRemGen'=>$lista_medRemGen,
        'medicoRemModel'=>$medicoRemModel,
        'lista_especialidades'=>$lista_especialidades,
        'lista_tipoid'=>$lista_tipoid,
        'campos'=>$campos,

    ]) ?>

</div>


<div id="plantillaModal" class="modal fade bs-example-modal-md plant" data-backdrop="true" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="plant"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button> -->
                <h4 class="titulo-tarifa">Plantillas</h4>
            </div>
            <div class="modal-body">

                <div class="form-group existente">
                    <div class="col-md-12">
                        <div class="col-md-12" style="padding-bottom:15px">
                            <label for="">Plantillas</label>
                            <?=Html::dropDownList('lista_titulos', '', ArrayHelper::map(PlantillasDiagnosticos::find()->where(['id_medico'=>Usuarios::findOne(Yii::$app->user->id)->idmedicos])->all(), 'id', 'titulo'), ['prompt'=>'Seleccione una opción','id'=>'lista', 'style'=>'width: 100%']) ?>
                        </div><br>

                         <div class="col-md-12" style="padding-bottom:15px">
                            <label for="">Descripción</label>
                            <?= Html::textArea('desc', '',['id'=>'descripcion', 'style'=>'width: 100%', 'rows'=>'4', 'cols'=>'50']); ?>
                         </div><br>
                         
                         <div class="col-md-12 text-center">
                            <a href="" disabled id="edicion" class="btn btn-default"><i class="add icon-guardar"></i>Guardar cambios</a>
                            <a href="" id="addDesc" class="btn btn-success"><i class="add icon-add"></i>Agregar</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="plantillaNuevaModal" class="modal fade bs-example-modal-md plant" data-backdrop="true" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
           <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="plant"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button> -->
                <h4 class="titulo-tarifa">Crear plantilla</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                     <div class="col-md-12">
                        <div class="col-md-12" style="padding-bottom:15px">
                            <?=Html::textInput('tituloName', '', ['placeHolder'=>'Titulo', 'style'=>'width: 100%']) ?>
                        </div><br>

                         <div class="col-md-12" style="padding-bottom:15px">
                            <?= Html::textArea('desc', '',['id'=>'descripcionNuevo', 'rows'=>'4', 'cols'=>'50', 'style'=>'width: 100%', 'placeHolder'=>'Descripción']); ?>
                         </div><br>
                         
                         <div class="col-md-12 text-center">
                            <a href="" id="guardarPlantilla" onClick="pasarTexto()" class="btn btn-success"><i class="add icon-guardar"></i>Guardar</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        $('#pacientes-fecha_nacimiento').val('<?=$model->idpacientes0->fecha_nacimiento?>');    
		$('#tipoID').val('<?=$model->idpacientes0->tipo_identificacion?>');

        $('#lista').on('change',  function(event) {
            var id = $('#lista').val();
            $('#descripcion').val('');

            if(id != ''){
                $.post('get-descripcion', {id: $('#lista').val()}).done(function(data) {
                    $('#descripcion').val(data);
                });
            }
        });
        $('#addDesc').on('click',  function(event) {
            event.preventDefault();
            var id = $(this).attr('data-value');
            $('#vlrscamposprocedimientos-'+id+'-valor').val($('#descripcion').val());
            $('#lista').val('');
            $('#descripcion').val('');
            $('#plantillaModal').modal('hide');
        });

        $('#guardarPlantilla').on('click', function(event) {
            event.preventDefault();
            var titulo = $('input[name="tituloName"]').val();
            var descripcion = $('#descripcionNuevo').val();
            if(titulo != '' && descripcion != '')
            {
                $.post('nueva-plantilla', {titulo: titulo, desc: descripcion}).done(function(data) {
                    alert(data);
                    $('input[name="tituloName"]').val('');
                    $('#descripcionNuevo').val('');
                    $('#plantillaNuevaModal').modal('hide');
                });
            }else{
                alert('Por favor verifique el titulo y la descripcion antes de guardar');
            }
        });

        $('#edicion').on('click',  function(event) {
            event.preventDefault();
            var id = $('#lista').val();
            var descripcion = $('#descripcion').val();

            $.post('editar-plantilla', {id: id, desc:descripcion}).done(function(data) {
                alert(data);
            });
        });

        $('#descripcion').on('keydown', function() {
            $('#edicion').removeAttr('disabled');
        });

        $('#plantillaModal').on('hidden.bs.modal', function() {
            $('#lista').val('');
            $('#descripcion').val('');
            $('#edicion').attr('disabled', '');
        });
	});

    function pasarTexto()
    {
        var id = $('#guardarPlantilla').attr('data-value');
        $('#vlrscamposprocedimientos-'+id+'-valor').val($('#descripcionNuevo').val());
    }
    
</script>
