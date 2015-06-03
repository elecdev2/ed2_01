<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimientos-form">

	<div class="panel panel-default">
        <div class="panel-body">
        	<div class="panelTituloBoton col-md-12">
	            <div class="col-md-12">
	                <h2 class="titulo tituloIndex">Reporte RIPS</h2>
	            </div>
	        </div>
        
			<div class="col-md-12 fomularioTituloReporte">
				<?php $form = ActiveForm::begin(['action'=>'reporte-rips']); ?>
					
					<div class="col-sm-6 col-lg-6">
						<?= $form->field($procedimientos, 'fecha_fin', ['template'=>"{input}{error}"])->dropDownList($lista_rips, ['prompt'=>'Reporte RIPS'])->label('');?>
					</div>

					<!-- <div class="col-sm-6 col-lg-6"> -->
						<!-- <?//echo $form->field($procedimientos, 'estado', ['template'=>"{input}{error}"])->dropDownList(['prompt'=>'Estado', 'FCT' => 'Facturado', 'FRM' => 'Firmado'])->label('');?> -->
					<!-- </div> -->
						
					<div class="col-sm-6 col-lg-6">
						<?= $form->field($ips, 'id', ['template'=>"{input}{error}"])->dropDownList($lista_ips, ['prompt'=>'Seleccione una IPS', 'id'=>'ips_id'])->label('');?>
					</div>

					<div class="col-sm-6 col-lg-6">
						<?= $form->field($procedimientos, 'eps_ideps', ['template'=>"{input}{error}"])->widget(DepDrop::classname(), [
				                    'type' => 2,
				                    'options'=>['id'=>'eps_id'],
				                    'pluginOptions'=>[
				                    'depends'=>['ips_id'],
				                    'placeholder'=>'Seleccione EPS',
				                    'url'=>Url::to(['/reportes/subeps'])
				                ]
				            ])->label('');
				        ?>
					</div>
					<div class="col-sm-6 col-lg-6">
				        <?= $form->field($procedimientos, 'fecha_inicio', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha de atención"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es'])->label('') ?>
					</div>

					<div class="col-sm-12 form-group botones-search">
				        <?= Html::submitButton('<i class="add icon-add"></i>Generar', ['class' =>'btn btn-success']) ?>
				    </div>
					
				<?php ActiveForm::end(); ?>
			</div>
		</div>
		<?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span>Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-botonReporte', 'data-value'=>$cerrar]);   ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        // $('.fomularioTitulo').hide();
        if($('.search-botonReporte').attr('data-value') != 1){
        	$('.fomularioTituloReporte').hide();
        }
        $('.search-botonReporte').on('click', function() {
            $('.fomularioTituloReporte').slideToggle('fast');
            return false;
        });
    });
</script>