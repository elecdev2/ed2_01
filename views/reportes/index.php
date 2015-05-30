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
                	<h2 class="titulo tituloIndex"><?=$titulo?></h2>
                </div>
            </div>
        
			<div class="col-md-12 fomularioTitulo">
				<?php $form = ActiveForm::begin(['action'=>$accion]); ?>

					<div class="col-sm-6 col-lg-6">
						<?= $form->field($procedimientos, 'estado', ['template'=>"{input}{error}"])->dropDownList(['prompt'=>'Seleccione un estado', 'FCT' => 'Facturado', 'FRM' => 'Firmado'])->label('');?>
					</div>
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
				        <?= $form->field($procedimientos, 'idtipo_servicio', ['template'=>"{input}{error}"])->widget(DepDrop::classname(), [
			                        'type' => 2,
			                        'options'=>['id'=>'tipo_id'],
			                        'pluginOptions'=>[
				                        'depends'=>['ips_id', 'eps_id'],
				                        'placeholder'=>'Seleccione tipo de estudio',
				                        'url'=>Url::to(['/reportes/subtipo'])
			                    	]
		               		])->label('');  
		            	?>
	            	</div>	
					<div class="col-sm-6 col-lg-6">
			        	<?= $form->field($procedimientos, 'fecha_inicio', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha inicio"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es'])->label('') ?>
					</div>
					<div class="col-sm-6 col-lg-6">
			        	<?= $form->field($procedimientos, 'fecha_salida', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha fin"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
					</div>

					<div class="col-sm-12 form-group botones-search">
				         <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
				    </div>
					
				<?php ActiveForm::end(); ?>
			</div>

		</div>
		<?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span>Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        // $('.fomularioTitulo').hide();
        $('.search-boton').on('click', function() {
            $('.fomularioTitulo').slideToggle('slow');
            return false;
        });
    });
</script>