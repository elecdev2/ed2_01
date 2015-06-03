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
                	<h2 class="titulo tituloIndex">Consultar facturación</h2>
            	</div>
            </div>
			<div class="col-md-12 fomularioTituloFactura">
				<?php $form = ActiveForm::begin(['action'=>'facturacion']); ?>
				
					<div class="col-sm-6 col-lg-4">
						<?= $form->field($procedimientos, 'estado', ['template'=>"{input}{error}"])->dropDownList(['prompt'=>'Seleccione un estado', 'FCT' => 'Facturado', 'FRM' => 'Firmado']);?>
					</div>
					<div class="col-sm-6 col-lg-4">
						<?= $form->field($ips, 'id', ['template'=>"{input}{error}"])->dropDownList($lista_ips, ['prompt'=>'Seleccione un IPS', 'id'=>'ips_id']);?>
					</div>
					<div class="col-sm-6 col-lg-4">
						<?= $form->field($procedimientos, 'eps_ideps', ['template'=>"{input}{error}"])->widget(DepDrop::classname(), [
				                    'type' => 2,
				                    'options'=>['id'=>'eps_id'],
				                    'pluginOptions'=>[
					                    'depends'=>['ips_id'],
					                    'placeholder'=>'Seleccione una EPS',
					                    'url'=>Url::to(['/facturas/subeps'])
				                ]
				            ]);  
				        ?>
					</div>
					<div class="col-sm-6 col-lg-6">
			       		<?= $form->field($procedimientos, 'fecha_inicio', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha inicio"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
					</div>
					<div class="col-sm-6 col-lg-6">
			        	<?= $form->field($procedimientos, 'fecha_fin', ['template'=>"{input}{error}"])->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "Fecha fin"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>
					</div>
					<div class="col-sm-12 form-group  botones-search">
				        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
				    </div>
					
				<?php ActiveForm::end(); ?>
			</div>

		</div>
		<?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-botonFactura', 'data-value'=> $fact]);   ?>
	</div>

<!-- Tablas de estudios -->

<?php if(isset($campos)){ 

	echo $this->render('factura_tablas', [
			'campos'=>$campos,
			'lista'=>$lista,
			'tipo'=>$tipo,
			'ips'=>$ips,
			'procedimientos'=>$procedimientos,
			'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'fact'=>$fact,
		]);

} ?>

</div>

<script type="text/javascript">
	$(document).ready(function() {
        if($('.search-botonFactura').attr('data-value') != 1){
        	$('.fomularioTituloFactura').hide();
        }
        $('.search-botonFactura').on('click', function() {
            $('.fomularioTituloFactura').slideToggle('fast');
            return false;
        });
    });
</script>