<?php 
use yii\helpers\Html;
use app\models\VlrsCamposProcedimientos;
use app\models\Campos;
 ?>

<?php if($campos[0]->titulos_idtitulos != null){ ?>
	<h4><?=Campos::findOne($campos[0]->id)->titulosIdtitulos->descripcion?></h4>
	<?php $titulo = $campos[0]->titulos_idtitulos;
 } ?>


<div class="container-fluid">

		<?php foreach ($campos as $campo) 
			{ 
				$val_campos = new VlrsCamposProcedimientos();
				if($model->estado != 'PND'){
					$val_campos = VlrsCamposProcedimientos::find()->where(['idcampos_tipos_servicio'=>$campo->id, 'id_procedimiento'=>$model->id])->one();
				}
					
					// $val_campos = (new \Yii\db\Query())->select('*')->from('vlrs_campos_procedimientos')->where(['idcampos_tipos_servicio'=>$campo['id'], 'id_procedimiento'=>$model->id])->all();
				
				// print_r($val_campos);
		?>

				
			<?php if($campo->tipo_campo == 'checkBox'){ ?> <!-- Titulos -->

				<?php if($campo->titulos_idtitulos != $titulo){ ?>
					<h4><?=Campos::findOne($campo->id)->titulosIdtitulos->descripcion; ?></h4>
					<?php  $titulo = $campo->titulos_idtitulos; 
				}?>

				<div class="col-sm-12" style="display:flex">
					<div class="col-sm-10">
						<?php if($model->estado !== 'PND' && !empty($val_campos)){ ?>
							<?= Html::input('checkBox','check_list[]',$campo->id,['checked'=>true]);?>
							<?= Html::label($model->estado == 'PRC' || $model->estado == 'FRM' ? ' ' : 'x','',['class'=>'']);?>
							<?= Html::label(utf8_encode(strtolower($campo->nombre_campo)),'',['class'=>'']);?>
						<?php }else{ ?>
							<?= Html::input('checkBox','check_list[]',$campo->id,['class'=>'']);?>
							<?= Html::label(' ','',['class'=>'']);?>
							<?= Html::label(utf8_encode(strtolower($campo->nombre_campo)),'',['class'=>'']);?>
						<?php } ?>
					</div>
				</div>

			<?php } ?>


			<?php if($campo->tipo_campo == 'textArea'){ ?>
	 			<?=$form->field($val_campos, '['.$campo->id.']valor')->textArea(['rows'=>'3', 'cols'=>'100'])->label($campo->nombre_campo);?>
	 			<?php if($imp !== 1){ ?>
		 			<div class="text-center">
		 				<a href="" class="plantillas" id="<?=$campo->id ?>" >Usar plantilla existente   </a>
		 				<a href="" class="plantillasNuevas" id="<?=$campo->id ?>" >		Guardar nueva plantilla</a>
		 			</div>
	 			<?php } ?>
			 	<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

			<?php if($campo->tipo_campo == 'textField'){ ?>
				<?=$form->field($val_campos, '['.$campo->id.']valor')->textInput()->label($campo->nombre_campo);?>
				<?php if($imp !== 1){ ?>
					<div class="text-center">
		 				<a href="" class="plantillas" id="<?=$campo->id ?>" >Usar plantilla existente   </a>
		 				<a href="" class="plantillasNuevas" id="<?=$campo->id ?>" > 	Guardar nueva plantilla</a>
		 			</div>
	 			<?php } ?>
				<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

<?php } ?>
</div>
