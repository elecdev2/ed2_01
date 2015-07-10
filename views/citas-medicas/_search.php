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

<div class="citas-medicas-search"  style="position:relative;top:6px;">

    <?php $form = ActiveForm::begin([
        'action' => ['index-ipss'],
        'method' => 'post',
    ]); ?>

   
    <div class="col-sm-3 col-lg-3">
        <?= $form->field($model, 'ips', ['template'=>"{input}{error}"])->widget(Select2::classname(), [
                'data'=>$ipss,
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione una IPS'],
                'pluginEvents'=>[
                    "change" => "function() { 
                        document.getElementById('btnIps').click();
                     }",
                ]
            ]);
        ?>
    </div>

    <div class="col-sm-12 form-group  botones-search" style="display:none">
        <?= Html::submitButton('Buscar', ['id'=>'btnIps', 'class' => 'btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    
</script>