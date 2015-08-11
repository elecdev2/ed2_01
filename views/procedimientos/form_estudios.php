<?php 
use yii\helpers\Html;
use app\models\VlrsCamposProcedimientos;
use app\models\Campos;
 ?>

<?php if($campos[0]->titulos_idtitulos != null){ ?>
	<div style="padding:0 15px;"><h5><?=Campos::findOne($campos[0]->id)->titulosIdtitulos->descripcion?></h5></div>
	<?php $titulo = $campos[0]->titulos_idtitulos;
		foreach ($campos as $campo) {
			if($campo->titulos_idtitulos != null){
				$titulo = $campo->titulos_idtitulos;
				break;
			}
		}
 } ?>


<div class="container-fluid">


		<?php foreach ($campos as $campo) 
			{ 
				$val_campos = new VlrsCamposProcedimientos();
				if($model->estado != 'PND'){
					$val_campos = VlrsCamposProcedimientos::find()->where(['idcampos_tipos_servicio'=>$campo->id, 'id_procedimiento'=>$model->id])->one();
				}
				// print_r($campos);
					
				
		?>

				
			<?php if($campo->tipo_campo == 'checkBox'){ ?> <!-- Titulos -->

				<?php if($campo->titulos_idtitulos != $titulo){ ?>
					<h5><?=Campos::findOne($campo->id)->titulosIdtitulos->descripcion; ?></h5>
					<?php  $titulo = $campo->titulos_idtitulos; 
				}?>

				<div class="col-sm-12">
					<?php if($model->estado !== 'PND' && $val_campos !== null){ ?>
						<?= Html::input('checkBox','check_list[]',$campo->id,['checked'=>'checked']);?>
						<?= Html::label(utf8_encode(strtolower($campo->nombre_campo)),'',['class'=>'']);?>
					<?php }else{ ?>
						<?= Html::input('checkBox','check_list[]',$campo->id,['class'=>'']);?>
						<?= Html::label(' ','',['class'=>'']);?>
						<?= Html::label(utf8_encode(strtolower($campo->nombre_campo)),'',['class'=>'']);?>
					<?php } ?>
				</div>
			

			<?php } ?>


			<?php if($campo->tipo_campo == 'textArea'){ ?>
	 			<?=$form->field($val_campos, '['.$campo->id.']valor')->textArea(['rows'=>'3', 'cols'=>'100'])->label($campo->nombre_campo);?>
	 			<?php if($imp !== 1){ ?>
		 			<div class="text-center">
		 				<a href="" class="plantillas btn btn-azul" id="<?=$campo->id ?>" >Usar plantilla existente</a>
		 				<a href="" class="plantillasNuevas btn btn-azul" id="<?=$campo->id ?>" >Crear nueva plantilla</a>
		 			</div>
	 			<?php } ?>
			 	<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

			<?php if($campo->tipo_campo == 'textField'){ ?>
				<?=$form->field($val_campos, '['.$campo->id.']valor')->textInput()->label($campo->nombre_campo);?>
				<?php if($imp !== 1){ ?>
					<div class="text-center">
		 				<a href="" class="plantillas btn btn-azul" id="<?=$campo->id ?>" >Usar plantilla existente</a>
		 				<a href="" class="plantillasNuevas btn btn-azul" id="<?=$campo->id ?>" >Crear nueva plantilla</a>
		 			</div>
	 			<?php } ?>
				<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

<?php } ?>

</div>
