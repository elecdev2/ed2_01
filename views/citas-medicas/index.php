<?php

use yii\helpers\Html;
use yii\grid\GridView;
use talma\widgets\FullCalendar;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasMedicasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas médicas';
// $this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    
        <div class="panel panel-default">
          <div class="panelTituloBoton" role="tab" id="headingOne" style="padding-left: 10px;">
            <h3 class="panel-title tituloIndex">
              <a role="button" data-toggle="collapse" style="display:block;" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Disponibilidad por médico
              </a>
            </h3>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
               
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panelTituloBoton" role="tab" id="headingTwo" style="padding-left: 10px;">
            <h4 class="panel-title tituloIndex">
              <a class="collapsed" role="button" data-toggle="collapse" style="display:block;" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Disponibilidad por especialidad
              </a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
            </div>
          </div>
        </div>
  </div> -->
<div class="panel panel-default panelBordeInferior">
    <div class="panel-body">
        <div class="panelTituloBoton col-md-12">
            <div class="col-sm-6">
                <h2 class="titulo tituloIndex"><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-sm-6">
                <h2 id="nombre_med" class="titulo tituloIndex" style="float:right;" data-value></h2>
            </div>
        </div>
        <div class="col-md-12 fomularioTituloCalendar">
            <?php if($num_ipss){echo $this->render('_search', ['model'=>$searchModel, 'ipss'=>$ipss]);} ?>
            <?= $this->render('_search2', ['model' => $searchModel, 'lista_esp'=>$lista_esp, 'num_ipss'=>$num_ipss]); ?>
        </div>
    </div>
</div>


<div class="citas-medicas-index">

<?php if($calendar == 1){ ?>

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
                'slotDuration'=> $modelIps->tiempo_citas,
                'minTime'=>$modelIps->hora_inicio,
                'maxTime'=>$modelIps->hora_fin,
                'defaultTimedEventDuration'=> $modelIps->tiempo_citas,
                'timeFormat'=>'h:mm',
                'aspectRatio'=>2.8,
                // 'contentHeight'=>'auto',
                'selectable'=>true,
                // 'hiddenDays'=>[ 1, 3, 5 ],
                'hiddenDays'=>new \yii\web\JsExpression("[".implode(',',$dias)."]"),
                // 'height'=> 300,

                'dayClick' => new \yii\web\JsExpression("function(date, jsEvent, view) {
                    var date = new Date(date);
                    var ips = $('#txtIdIps').val();
                    var num_ips = $('#num_ips').val();
                    var dia = moment(date).format('d');
                    var med = $('#nombre_med').attr('data-value') == '' ? null : $('#nombre_med').attr('data-value');
                    
                    $.get('create', {date: date.toISOString(), ips:ips, num_ips:num_ips, dia:dia, med:med}).done(function(data) {
                        if(data == 0){
                            bootbox.alert('No disponilbe!');

                        }else{

                            $('#citas').html(data);
                            var titulo = $('#helperHid').attr('data-titulo');
                            $('.modal-title').text('');
                            $('.modal-title').text(titulo);
                            if(med != null){
                                $('#citasmedicas-medicos_id').select2('val', $('#nombre_med').attr('data-value'));
                            }
                            $('#citasModal').modal({backdrop:'static'});
                        }
                    });
                   
                }"),

                'events'=> $events != '' ? new \yii\web\JsExpression($events) : $events,

                'eventClick' => new \yii\web\JsExpression("function(event, jsEvent, view) {
                    var id_cita = event.id;
                    var ips = $('#txtIdIps').val();
                    var num_ips = $('#num_ips').val();
                    $.get('update', {id: id_cita, ips:ips, num_ips:num_ips}).done(function(data) {
                        $('#citas').html(data);
                        var titulo = $('#helperHid').attr('data-titulo');
                        $('.modal-title').text('');
                        $('.modal-title').text(titulo);
                        $('#citasModal').modal({backdrop:'static'});
                    });
                }"),

                'eventStartEditable'=>true,

                'eventDrop' => new \yii\web\JsExpression("function(event, delta, revertFunc) {

                    var dia = moment(event.start).format('d');
                    var med = $('#nombre_med').attr('data-value') == '' ? null : $('#nombre_med').attr('data-value');

                    if(med == null){
                        bootbox.alert('Para mover la cita dirijase al calendario del médico');
                        revertFunc();
                    }else{

                        bootbox.confirm('¿Está seguro que desea realizar este cambio?', function(result) {
                            if(!result){
                                revertFunc();
                            }else{
                                $.post('cambiar-fecha', {date: event.start.format(), id:event.id, med:med}).done(function(data) {
                                    if(data == 0){
                                        revertFunc();
                                        bootbox.alert('No se puede realizar ese cambio');
                                    }else{
                                       bootbox.alert(data);
                                    }
                                });
                            }
                        }); 
                    }
                    

                }"),
            ],
        ]); ?>
<?php } ?>

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

    <div class="modal">
            <div class="loader"></div>
    </div>

</div>
