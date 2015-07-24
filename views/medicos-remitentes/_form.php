<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MedicosRemitentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-remitentes-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medRemForm', 'validateOnType' => true]); ?>
    
    <input type="text" name="url" id="url" hidden>  
    <div class="help-block help-block-error "></div>
    <?= $form->field($ips_model, 'id')->dropDownList(ArrayHelper::map($ips_list,'id','nombre'), ['name'=>'ips', 'prompt'=>'Seleccione una opción', 'id'=>'ips_id'])->label('IPS');?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'especialidades_id')->widget(Select2::classname(), [
                'data'=>$lista_especialidades,
                'language' => 'es',
                'class'=>'medField',
                // 'disabled'=>true,
                'options' => ['placeholder' => 'Seleccione una especialidad'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Especialidades');
        ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
    $js = <<<SCRIPT

$('form#medRemForm').on('beforeSubmit', function(e)
{
    var \$form = $(this);

    $.post(
        \$form.attr("action"), 
        \$form.serialize()
    )
    .done(function(result) {
        if(result == 1)
        {
            $(document).find('#updateModal').modal('hide');
            $.pjax.reload({container:'#medicosRem_pjax'});
            bootbox.alert('Se guardaron los cambios');
        }else{
            bootbox.alert('Error al guardar los cambios');
        }
    })
    .fail(function(){
        console.log("Server error");
    });
    return false;
});

SCRIPT;
$this->registerJs($js);

?>, 