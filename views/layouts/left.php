<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

?>
<aside class="left-side sidebar-offcanvas">

    <section class="sidebar">

       

        <!-- <p class="text-center">
            <img src="<?//echo Yii::$app->request->baseUrl; ?>/images/LogoFin50pxapp.png" alt="" style="width:90%" class="responsive">
        </p> -->



        <!-- You can delete next ul.sidebar-menu. It's just demo. -->

        <ul class="sidebar-menu">
 
            <?php if(Yii::$app->user->can('procedimientos')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/procedimientos/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconProcedimiento.png" alt="">Procedimientos</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('pacientes')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/pacientes/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconPacientes.png" alt="" >Pacientes</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('hist_clinica')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/historia-clinica/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconHistorial.png" alt="" >Historia clinica</a></li>
            <?php } ?>

                <li><a href="<?=Yii::$app->request->baseUrl;?>/atencion/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconAtenPaciente.png" alt="" >Consultas</a></li>

            <?php if(Yii::$app->user->can('medicos')){ ?>
                <li class="treeview">
                   <a href=""><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconMedicos.png" alt="" >Médicos
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/MedTratante.png" alt="" > Médicos tratantes', ['medicos/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/MedRemitente.png" alt="" > Médicos remitentes', ['medicos-remitentes/index'], ['class' => '']) ?></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if(Yii::$app->user->can('EPS')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/eps/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconEPS.png" alt="" >EPS</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('usuarios')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/usuarios/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconUsuarios.png" alt="" >Usuarios</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('facturacion')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/facturas/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconFacturacion.png" alt="" >Facturación</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <li><a href="<?=Yii::$app->request->baseUrl;?>/recibos/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconRecibos.png" alt="" >Recibos</a></li>
            <?php } ?>

            <?php if(Yii::$app->user->can('reportes')){ ?>
                <li class="treeview">
                   <a href=""><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl?>/images/iconos/IconReportes.png" alt="" >Reportes
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/consultEstudios.png" alt="" > Consultar estudios', ['reportes/index','t'=>1], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/SaldosPendientes.png" alt="" > Saldos pendientes', ['reportes/index', 't'=>2], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/ReportesRips.png" alt="" > Reporte RIPS', ['reportes/rips'], ['class' => '']) ?></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if(Yii::$app->user->can('plantillas')){ ?>
                    <li><a href="<?=Yii::$app->request->baseUrl;?>/plantillas-diagnosticos/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconPlantillas.png" alt="" >Plantillas</a></li>
            <?php } ?>

             <?php if(Yii::$app->user->can('auxiliar')){ ?>
                <li class="treeview">
                   <a href=""><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconCitas.png" alt="" >Citas médicas
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/IconAgendaCitas.png" alt="" > Agenda de citas', ['citas-medicas/index'], ['class' => '']) ?></li>
                        <?php if(Yii::$app->user->can('medico')){ ?>
                            <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/IconMiCita.png" alt="" > Mi agenda', ['citas-medicas/medico'], ['class' => '']) ?></li>
                        <?php } ?>
                         <?php if(Yii::$app->user->can('admin')){ ?>
                            <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/IconConfigCitas.png" alt="" > Configuración', ['citas-medicas/config'], ['class' => '']) ?></li>
                            <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconInformes.png" alt="" > Reporte de citas', ['citas-medicas/reporte'], ['class' => '']) ?></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

                
            <?php if(Yii::$app->user->can('super_admin')){ ?>
                <li class="treeview">
                   <a href=""><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl?>/images/iconos/IconAdmin.png" alt="" >Admin
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconClientes.png" alt="" > Clientes', ['clientes/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconIPS.png" alt="" > Ips\'s', ['ips/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconServicios.png" alt="" > Tipos de servicio', ['tipos-servicio/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconListas.png" alt="" > Listas del sistema', ['listas-sistema/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconCampos.png" alt="" > Campos', ['campos/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconEspeciali.png" alt="" > Especialidades', ['especialidades/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconPerfiles.png" alt="" > Perfiles', ['items/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconInformes.png" alt="" > Informes', ['informes/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconEstudios.png" alt="" > Estudios', ['estudios/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconEstudios.png" alt="" > Estudios-ips', ['estudios-ips/index'], ['class' => '']) ?></li>
                        <li class="" role="presentation"><?=Html::a('<img class="subsidebar-icon" src="'.Yii::$app->request->baseUrl.'/images/iconos/AdminIconResultados.png" alt="" > Resultados', ['site/index-resultados'], ['class' => '']) ?></li>
                    </ul>
                </li>
            <?php } ?>

        </ul>

    </section>

</aside>
<script type="text/javascript" charset="utf-8">
    $(function() {
        $('.sidebar .sidebar-menu > li > a').each(function() {
            if ($(this).attr('href')  ===  window.location.pathname) {
              $(this).addClass('active');
            }
        });
    });  
</script>

