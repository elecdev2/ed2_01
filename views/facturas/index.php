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
			<div class="col-md-12 fomularioTitulo">
				<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'action'=>'facturacion']); ?>

					<?= $form->field($procedimientos, 'estado')->dropDownList(['prompt'=>'Seleccione una opción', 'FCT' => 'Facturado', 'FRM' => 'Firmado'])->label('Estado');?>
					
					<?= $form->field($ips, 'id')->dropDownList($lista_ips, ['prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

					<?= $form->field($procedimientos, 'eps_ideps')->widget(DepDrop::classname(), [
			                    'type' => 2,
			                    'options'=>['id'=>'eps_id'],
			                    'pluginOptions'=>[
			                    'depends'=>['ips_id'],
			                    'placeholder'=>'Seleccione EPS',
			                    'url'=>Url::to(['/facturas/subeps'])
			                ]
			            ])->label('EPS');  
			        ?>

			        <?= $form->field($procedimientos, 'fecha_inicio')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

			        <?= $form->field($procedimientos, 'fecha_fin')->widget(yii\jui\DatePicker::classname(), ["dateFormat" => "yyyy-MM-dd", 'options' => ['class' => 'fecha form-control', "placeholder" => "aaaa-mm-dd"], 'clientOptions'=>['changeMonth'=>'true', 'changeYear'=>'true'], 'language'=>'es']) ?>

					<div class="form-group text-center">
				        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['class' => 'busqueda-boton btn btn-success']) ?>
				    </div>
					
				<?php ActiveForm::end(); ?>
			</div>

		</div>
		<?= Html::a('<span class="busqueda glyphicon glyphicon-search"></span> Busqueda <i class="fa fa-caret-down fa-lg"></i>','#',['class'=>'search-boton']);   ?>
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
        // $('.fomularioTitulo').hide();
        $('.search-boton').on('click', function() {
            $('.fomularioTitulo').slideToggle('slow');
            return false;
        });
    });
</script>