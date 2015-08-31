<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\CitasMedicas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panelTituloCrear col-md-12">
                <div class="col-md-6">
                    <h2 class="titulo tituloIndex">Configuración de citas</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="citas-medicas-form" style="padding:15px 0;">

            <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id'=>'configForm', 'validateOnType' => true, 'action'=>'config-cita']); ?>

                <?= $form->field($model, 'id')->widget(Select2::classname(), [
                        'data'=>$ips_list,
                        'language' => 'es',
                        'options' => ['placeholder' => 'Seleccione una opción'],
                        'pluginEvents' => [
                            "change" => "function() { 
                                $.post('consulta-horas', {id: $('#ips-id').val()}).done(function(data) {
                                    $('#ips-tiempo_citas').val(data['tiempo_citas']);
                                    $('#ips-hora_inicio').val(data['hora_inicio']);
                                    $('#ips-hora_fin').val(data['hora_fin']);
                                    $('#ips-tiempo_cierre').val(data['tiempo_cierre']);
                                });
                             }",
                        ]
                    ])->label('IPS');
                ?>

                <?= $form->field($model, 'tiempo_citas')->textInput(['placeholder'=>'hh:mm'])->label('Duración de las citas *') ?>

                <?= $form->field($model, 'hora_inicio')->textInput(['type'=>'time'])->label('Hora de inicio de atención *') ?>

                <?= $form->field($model, 'hora_fin')->textInput(['type'=>'time'])->label('Hora de fin de atención *') ?>

                <?= $form->field($model, 'tiempo_cierre')->textInput(['required'=>true])->label('Cierre automatico de citas (# dias) *') ?>

                <div class="text-center">
                    <?= Html::submitButton('<i class="add icon-actualizar"></i>Actualizar', ['class' =>'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>

