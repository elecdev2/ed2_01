<?php

use yii\helpers\Html;
use yii\grid\GridView;
use talma\widgets\FullCalendar;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasMedicasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas médicas';
// $this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="panelTituloBoton col-md-12">
            <div class="col-sm-6">
                <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-sm-6">
                <!-- <a href="#" id="renderEvents" onclick="refreshCalendar()" class="btn btn-success crear" data-value="<?=$id_medico?>"><i class="add icon-add"></i>Refrescar</a> -->
                <button id="renderEvents" onclick="refreshCalendar()" class="btn btn-success crear" data-value="<?=$id_medico?>"><i class="add icon-refresh"></i>Refrescar</button>
            </div>
        </div>
    </div>
</div>

<div class="citas-medicas-index">


        <?= FullCalendar::widget([
            'config' => [
                'header'=>[
                    'left'=>'prev,next today',
                    'center'=>'title',
                    'right'=>'month,agendaWeek,agendaDay',
                ],
                'defaultView'=>'agendaDay',
                'lang'=>'es',
                'allDaySlot'=>false,
                'axisFormat'=>'h(:mm)a',
                'slotDuration'=>$ips->tiempo_citas,
                'minTime'=>$ips->hora_inicio,
                'maxTime'=>$ips->hora_fin,
                'defaultTimedEventDuration'=>$ips->tiempo_citas,
                'timeFormat'=>'h:mm',
                'aspectRatio'=>2.5,

                'events'=> $events != '' ? new \yii\web\JsExpression($events) : $events,

                'eventClick' => new \yii\web\JsExpression("function(event, jsEvent, view) {
                    var id_cita = event.id;
                    $.get('view', {id: id_cita}).done(function(data) {
                        $('#citas').html(data);
                        $('#citasModal h3.modal-title').text('Datos de la cita');
                        $('#citasModal').modal({backdrop:'static'});
                    });
                }"),

                'loading' => new \yii\web\JsExpression("function(isLoading, view) {
                    if(isLoading){
                        $('.modal').show();
                    }else{
                        $('.modal').hide();
                    }
                }"),

            ],
        ]); ?>
</div>

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

<div id="historiaModal" class="modal fade bs-example-modal-lg" data-backdrop="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" onclick="swichtWIndow(historiaModal,citasModal)"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div id='historia'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal">
    <div class="loader"></div>
</div>
