<?php

use yii\helpers\Html;
use yii\grid\GridView;
use talma\widgets\FullCalendar;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasMedicasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas Medicas';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-medicas-index">

    <?= FullCalendar::widget([
        'loading' => 'Cargando...', // Text for loading alert. Default 'Loading...'
        'config' => [
            'header'=>[
                'left'=>'prev,next today',
                'center'=>'title',
                'right'=>'month,agendaWeek,agendaDay',
            ],
            'defaultView'=>'agendaWeek',
            'lang'=>'es',
            'allDaySlot'=>false,
            'axisFormat'=>'h(:mm)a',
            'slotDuration'=>'00:15:00',
            'minTime'=>"05:00:00",
            'maxTime'=>"22:00:00",
            'defaultTimedEventDuration'=>'00:15:00',
            'timeFormat'=>'h:mm',

            'dayClick' => new \yii\web\JsExpression("function(date, jsEvent, view) {
                var date = new Date(date);
                $.post('create', {date: date.toISOString()}).done(function(data) {
                    $('#citas').html(data);
                    var titulo = $('#helperHid').attr('data-titulo');
                    $('.modal-title').text('');
                    $('.modal-title').text(titulo);
                    $('#citasModal').modal({backdrop:'static'});
                });
            }"),

            'events'=> new \yii\web\JsExpression($events),

            'eventClick' => new \yii\web\JsExpression("function(event, jsEvent, view) {
                var id_cita = event.id;
                $.post('update', {id: id_cita}).done(function(data) {
                    $('#citas').html(data);
                    var titulo = $('#helperHid').attr('data-titulo');
                    $('.modal-title').text('');
                    $('.modal-title').text(titulo);
                    $('#citasModal').modal({backdrop:'static'});
                });
            }"),
        ],
    ]); ?>

    <div id="citasModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                    <h3 class="modal-title"></h3>
                </div>
                <div class="modal-body">
                    <div id='citas'></div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="updateCitas" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                    <h3 class="titulo-tarifa">Editar cita</h3>
                </div>
                <div class="modal-body">
                    <div id='citasUpd'></div>
                </div>
            </div>
        </div>
    </div> -->

</div>
