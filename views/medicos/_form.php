<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Medicos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicos-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'medForm', 'validateOnType' => true, 'options'=>['enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'idclientes')->hiddenInput(['value'=>$model->isNewRecord ? $id_cliente: $model->idclientes])->label('') ?>
     <input type="text" name="url" id="url" hidden>
     <!-- <div class="help-block help-block-error "></div> -->
     
    <?= $form->field($model, 'ips_idips')->widget(Select2::classname(), [
            'data'=>$lista_ips,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una IPS'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('IPS');
    ?>
    

    <?= $form->field($model, 'idespecialidades')->widget(Select2::classname(), [
            'data'=>$lista_especialidades,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una especialidad'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Especialidades');
    ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => 15])->label('Código') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'color')->widget(Select2::classname(), [
            'data'=>$lista_colores,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un color'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents'=>[
                "change" => "function() {
                    $.post('consultar-color', {id: $('#medicos-color').val()}).done(function(data) {
                        $('#colorBox').css('background-color', data);
                    });
                }",

            ]
        ])->label('Color');
    ?>



    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
    $js = <<<SCRIPT

$('form#medForm').on('beforeSubmit', function(e)
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
            $.pjax.reload({container:'#medicos_pjax'});
            notification('Se guardaron los cambios', 1);
        }else{
            notification('Error al guardar los cambios', 2);
        }
    })
    .fail(function(){
        notification("Server error", 2);
    });
    return false;
});

SCRIPT;
$this->registerJs($js);

?>