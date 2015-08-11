<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-medicas-search" style="position:relative;top:6px;">

    <?php $form = ActiveForm::begin([
        'action' => ['calendar'],
        'method' => 'post',
    ]); ?>

    <input type="text" hidden id="txtIdIps" name="ips">
    <input type="text" hidden name="num_ips" id="num_ips" value="<?=$num_ipss?>">
    <div class="<?=$num_ipss == true ? 'col-sm-4 col-lg-4' : 'col-sm-5 col-lg-5'?>">
        <?= $form->field($model, 'idespecialidades', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
                'data'=>$lista_esp,
                'language' => 'es',
                'options' => ['id'=>'esp', 'placeholder' => 'Seleccione una opción'],
            ]);
        ?>
    </div>

    <div class="<?=$num_ipss == true ?  "col-sm-4 col-lg-4" : "col-sm-5 col-lg-5"?>">
         <?= $form->field($model, 'medicos_id', ['template'=>"{input}{error}"])->widget(DepDrop::classname(), [
                    'type' => 2,
                    'options'=>['id'=>'med_id'],
                    'pluginOptions'=>[
                        'depends'=>['esp', 'txtIdIps'],
                        'placeholder'=>'Seleccione un médico',
                        'url'=>Url::to(['/citas-medicas/submed2'])
                    ],
                  
            ]);  
        ?>
    </div>

    <div class="col-sm-1 botones-search" style="display:none">
        <?= Html::submitButton('<i class="busq search-icon"></i>Buscar', ['id'=>'submmitCalendar', 'class' => 'busqueda-boton btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#med_id').on('change', function(event) {
            if($(this).val() !== ''){
                document.getElementById('submmitCalendar').click();
            }
        });
    });
</script>