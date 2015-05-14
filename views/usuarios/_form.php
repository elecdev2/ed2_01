<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'usuarioForm', 'validateOnType' => true, 'options'=>['onsubmit'=>'submitForm']]); ?>

    <?= $form->field($model, 'idclientes')->hiddenInput(['value'=>$model->isNewRecord ? $id_cliente: $model->idclientes])->label('') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'perfil')->widget(Select2::classname(), [
            'data'=>$lista_perf,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un perfil'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Perfil');
    ?>

    <?= $form->field($model, 'activo')->dropDownList(['1' => 'Si', '2' => 'No'])->label('Activo') ?>

<?php if($model->isNewRecord){ ?>    
    <div class="form-group field-medico-check">
        <div class="col-sm-6 text-center">
            <input type="checkbox" id="showHidePanel">
            <label for="showHidePanel">Médico?</label>
        </div>
    </div>
<?php } ?>

<div class="panel panel-default">
    <div id="panelMedico"  class="panel-body">
        <?= $form->field($modelMedico, 'ips_idips')->widget(Select2::classname(), [
                'data'=>$lista_ips,
                'language' => 'es',
                'class'=>'medField',
                'options' => ['placeholder' => 'Seleccione una IPS'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('IPS');
        ?>


        <?= $form->field($modelMedico, 'idespecialidades')->widget(Select2::classname(), [
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

        <?= $form->field($modelMedico, 'codigo')->textInput(['class'=>'medField'])->label('Código') ?>

        <?= $form->field($modelMedico, 'idclientes')->hiddenInput(['class'=>'medField','value'=>$model->isNewRecord ? $id_cliente: $model->idclientes])->label('') ?>
    </div>
</div>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class'=>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#panelMedico').hide();
        $('#showHidePanel').on('change', function(event) {
            event.preventDefault();
            $('#panelMedico').hide();
            if($('#showHidePanel').is(':checked')){
                $('#panelMedico').show();
            }
        }); 
        
    });
</script>
