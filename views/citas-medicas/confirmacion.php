<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
 ?>


<?php $form = ActiveForm::begin(['id' => 'confForm', 'validateOnType' => true, 'action'=>'cambiar-fecha']); ?>

    <?= $form->field($model, 'fecha')->textInput(['disabled'=>true]) ?>
    
    <?= $form->field($model, 'hora')->widget(Select2::classname(), [
            'data'=>$horario_med,
            'language' => 'es',
            'readonly'=>true, 
            'options' => ['placeholder' => 'Seleccione una opción'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Horas disponibles');
    ?>

    <input type="text" id="med" hidden name="med">
    <input type="text" id="id" hidden name="id">
    <input type="text" id="date" hidden name="date">
    <input type="text" id="sw" hidden name="sw" value="0">

     <div class='col-sm-12 text-center' style="display:none">
        <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['id'=>'submitConf', 'class' =>'btn btn-success']) ?>
        <a href="#" id="cancelar" data-dismiss="modal" class="btn btn-default">Cancelar</a>
    </div>
<?php ActiveForm::end(); ?>

<?php 
    $js = <<<SCRIPT

$('form#confForm').on('beforeSubmit', function(e)
{
    var \$form = $(this);
    var event_id = $('#id').val();

    $.post(
        \$form.attr("action"), 
        \$form.serialize()
    )
    .done(function(result) {
        switch (result) {
            case '0':
                notification('Error al guardar los cambios', 2);
                break;
            case '1':
                notification('Ya existe una cita a esa hora', 2);
                break;
            case '2':
                notification('La fecha es anterior al día de hoy', 2);
                break;
            case '3':
                notification('La hora es anterior a la hora actual', 2);
                break;
            case '4':
                notification('La hora está por fuera del horario del médico', 2);
                break;
            default:
                $('#moveCitasModal').modal('hide');
                var evento = $('.fullcalendar').fullCalendar( 'clientEvents',  event_id);
                var new_event = {
                    'id':result.id_citas,
                    'title':evento[0].title,
                    'start':result.fecha,
                    'color':'#468CCA',
                    'medico':evento[0].medico
                };
                $('.fullcalendar').fullCalendar( 'removeEvents', event_id );
                $('.fullcalendar').fullCalendar( 'renderEvent', new_event, true );
                $('.fullcalendar').fullCalendar( 'rerenderEvents' );
                notification('La cita fue reprogramada', 1);
                break;
        }
        
    })
    .fail(function(){
        notification('Server error', 2);
        // console.log("Server error");
    });
    return false;
});

SCRIPT;
$this->registerJs($js);

?>