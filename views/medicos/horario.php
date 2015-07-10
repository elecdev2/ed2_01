<?php

use yii\helpers\Html;
use yii\grid\GridView;
use talma\widgets\FullCalendar;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasMedicasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horario '.$model->nombre;
// $this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="panelTituloBoton col-md-12">
            <div class="col-sm-6">
                <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-6">
                <?= Html::a('<i class="add icon-back"></i>Regresar', ['index'], ['class' => 'btn btn-success crear']);?>
            </div>
        </div>
    </div>
    <input type="text" id="med" hidden value="<?=$model->id?>">
</div>

<div class="horario-medico">
        <?php 
            $duracion_citas = $model->ipsIdips->tiempo_citas;
            $hora_inicio = $model->ipsIdips->hora_inicio;
            $hora_fin = $model->ipsIdips->hora_fin;
         ?>

        <?= FullCalendar::widget([
            'config' => [
                'header'=>[
                    // 'left'=>'prev,next today',
                    // 'center'=>'title',
                    // 'right'=>'agendaWeek',
                ],
                'firstDay'=> new \yii\web\JsExpression("2015-07-12"),
                'columnFormat'=> 'dddd',
                'defaultView'=>'agendaWeek',
                'lang'=>'es',
                'allDaySlot'=>false,
                'axisFormat'=>'h(:mm)a',
                'slotDuration'=> $duracion_citas != null ? $duracion_citas : '00:20:00',
                'minTime'=> $hora_inicio,
                'maxTime'=> $hora_fin,
                'defaultTimedEventDuration'=>$duracion_citas != null ? $duracion_citas : '00:20:00',
                'timeFormat'=>'h:mm',
                'aspectRatio'=>2.3,
                'selectable'=>true,
                'selectOverlap'=>false,

                'events'=> $events != '' ? new \yii\web\JsExpression($events) : $events,

                'select' => new \yii\web\JsExpression(
                    "function( start, end, jsEvent, view ) {
                        bootbox.confirm('¿Está seguro que desea guardar este rango de horas?', function(result) {
                            if(result){
                                var inicio = moment(start).format('dTHH:mm'); 
                                var fin = moment(end).format('dTHH:mm');
                                $.post('crear-horas', {start: inicio, end: fin, id:$('#med').val()}).done(function(data) {
                                    // console.log(data);
                                    $('.fullcalendar').fullCalendar('addEventSource', [{
                                        id: data,
                                        start: start,
                                        end: end,
                                        title: moment(start).format('h:mm a')+'-'+moment(end).format('h:mm a'),
                                        inicio: moment(start).format('HH:mm'),
                                        fin: moment(end).format('HH:mm'),
                                        rendering: 'background',
                                        block: true,
                                        overlap: false,
                                    }, ]);
                                    $('.fullcalendar').fullCalendar('unselect');
                                });
                            }
                        });
                        
                    }"
                ),

                'eventClick' => new \yii\web\JsExpression("function(event, jsEvent, view) {
                    var id_rango = event.id;
                    bootbox.confirm('¿Está seguro que desea borrar este rango de horas?', function(result) {
                        if(result)
                        {
                            $.get('delete-rango', {id: id_rango, inicio:event.inicio, fin:event.fin}).done(function(data) {
                                console.log(data);

                                
                                var source = 'consultar-horas?id='+data;
                                $('.fullcalendar').fullCalendar(  'removeEvents' );
                                $('.fullcalendar').fullCalendar('removeEventSource', source);
                                $('.fullcalendar').fullCalendar('addEventSource', source);

                            });
                        }
                    });
                }"),

                'selectOverlap'=>  new \yii\web\JsExpression(
                    "function(event) {
                        return ! event.block;
                    }"
                ),


            ],
        ]); ?>
</div>
