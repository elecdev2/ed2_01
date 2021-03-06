<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarifas-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'tarifasForm', 'validateOnType' => true]); ?>

    <?= $form->field($model, 'eps_id')->hiddenInput(['value'=>$model->isNewRecord ? $ideps : $model->eps_id])->label('') ?>

    <?php if($model->isNewRecord){ ?>
        <?= $form->field($model, 'idestudios')->widget(Select2::classname(), [
                'data'=>$lista_estudios,
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione un estudio'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Estudio');
        ?>
    <?php } ?>

    <?= $form->field($model, 'valor_procedimiento')->textInput() ?>

    <?= $form->field($model, 'descuento')->textInput() ?>

    <input type="text" hidden name="ideps" value="<?=$ideps?>">

    <input type="text" name="url" id="url" hidden>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="add icon-guardar"></i>Crear' : '<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
    $js = <<<SCRIPT

$('form#tarifasForm').on('beforeSubmit', function(e)
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
            $(document).find('#tarModal').modal('hide');
            $.pjax.reload({container:'#tarifasTab', timeout: 5000});
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

?>