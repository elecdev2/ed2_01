<?php 
use yii\helpers\Html;
use app\models\VlrsCamposProcedimientos;
use app\models\Campos;
 ?>

<?php if($campos[0]->titulos_idtitulos != null){ ?>
	<h4><?=Campos::findOne($campos[0]->id)->titulosIdtitulos->descripcion?></h4>
	<?php $titulo = $campos[0]->titulos_idtitulos;
 } ?>


<?php foreach ($campos as $campo) 
	{ 
		$val_campos = new VlrsCamposProcedimientos();
		if($model->estado != 'PND'){
			$val_campos = VlrsCamposProcedimientos::find()->where(['idcampos_tipos_servicio'=>$campo->id, 'id_procedimiento'=>$model->id])->one();
		}
			
			// $val_campos = (new \Yii\db\Query())->select('*')->from('vlrs_campos_procedimientos')->where(['idcampos_tipos_servicio'=>$campo['id'], 'id_procedimiento'=>$model->id])->all();
		
		// print_r($val_campos);
?>


		<div class="container-fluid">
				
			<?php if($campo->tipo_campo == 'checkBox'){ ?> <!-- Titulos -->

				<?php if($campo->titulos_idtitulos != $titulo){ ?>
					<h4><?=Campos::findOne($campo->id)->titulosIdtitulos->descripcion; ?></h4>
					<?php  $titulo = $campo->titulos_idtitulos; 
				}?>

				<div class="col-sm-12">

					<div class="col-sm-1">
						<?php if($model->estado !== 'PND' && !empty($val_campos)){ ?>
							<?= Html::input('checkBox','check_list[]',$campo->id,['class'=>'', 'checked'=>true]);?>
						<?php }else{ ?>
							<?= Html::input('checkBox','check_list[]',$campo->id,['class'=>'', 'checked'=>false]);?>
						<?php } ?>
					</div>
				 	<div class="col-sm-11">
						<?= Html::label(utf8_encode(strtolower($campo->nombre_campo)),'',['class'=>'']);?>
				 	</div>

				</div>

			<?php } ?>


			<?php if($campo->tipo_campo == 'textArea'){ ?>
		 		<?=$form->field($val_campos, '['.$campo->id.']valor')->textArea(['size' => 60, 'maxlength' => 300])->label($campo->nombre_campo);?>
		 		<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

			<?php if($campo->tipo_campo == 'textField'){ ?>
				<?=$form->field($val_campos, '['.$campo->id.']valor')->textInput()->label($campo->nombre_campo);?>
				<?=$form->field($val_campos, 'idcampos_tipos_servicio[]')->hiddenInput(['value'=>$campo->id])->label('');?>
			<?php } ?>

		</div>
<?php } ?>
