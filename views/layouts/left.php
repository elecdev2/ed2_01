<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

?>
<aside class="left-side sidebar-offcanvas">

    <section class="sidebar">

       

        <p class="text-center">
            <img src="<?= Yii::$app->request->baseUrl; ?>/images/LogoFin50pxapp.png" alt="" style="width:90%" class="responsive">
        </p>



        <!-- You can delete next ul.sidebar-menu. It's just demo. -->

        <ul class="sidebar-menu">

            <li><a href="<?=Yii::$app->request->baseUrl;?>/procedimientos/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-65(1).png" alt="">Procedimientos</a></li>

            <li><a href="<?=Yii::$app->request->baseUrl;?>/pacientes/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-66(1).png" alt="" >Pacientes</a></li>

            <li><a href="<?=Yii::$app->request->baseUrl;?>/medicos/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-67(1).png" alt="" >Médicos</a></li>
            
            <li><a href="<?=Yii::$app->request->baseUrl;?>/eps/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-68(1).png" alt="" >EPS</a></li>
            
            <li><a href="<?=Yii::$app->request->baseUrl;?>/usuarios/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-70(1).png" alt="" >Usuarios</a></li>
            
            <li><a href="<?=Yii::$app->request->baseUrl;?>/facturas/index"><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl;?>/images/iconos/iconos-711.png" alt="" >Facturación</a></li>
            
            
            <?php if(Yii::$app->user->can('super_admin')){ ?>
            <li class="treeview">
               <a href=""><img class="sidebar-icon" src="<?=Yii::$app->request->baseUrl?>/images/iconos/iconos-72(1).png" alt="" >
                    <span>Panel admin...</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Clientes', ['clientes/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Ips\'s', ['ips/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Tipos de servicio', ['tipos-servicio/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Listas del sistema', ['listas-sistema/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Campos', ['campos/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Especialidades', ['especialidades/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Perfiles', ['#'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Informes', ['informes/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Estudios', ['estudios/index'], ['class' => '']) ?></li>
                    <li class="" role="presentation"><?=Html::a('<i class="fa fa-angle-double-right"></i> Resultados', ['#'], ['class' => '']) ?></li>
                </ul>
            </li>
            <?php } ?>

            <!-- <li class="active">
                <a href="<?= Yii::$app->request->baseUrl; ?>/clientes/index">
                    <i class=""></i> <span>Clientes</span>
                </a>
            </li>
            <li>
                <a href="<?= Yii::$app->request->baseUrl; ?>/ips/index">
                    <i class="fa fa-th"></i> <span>IPS's</span>
                </a>
            </li>
            <li>
                <a href="<?= Yii::$app->request->baseUrl; ?>/tipos-servicio/index">
                    <i class="fa fa-th"></i> <span>Tipos de servicio</span>
                </a>
            </li>
            <li>
                <a href="<?= Yii::$app->request->baseUrl; ?>/listas-sistema/index">
                    <i class="fa fa-th"></i> <span>Listas del sistema</span>
                </a>
            </li>
            <li>
                <a href="<?= Yii::$app->request->baseUrl; ?>/campos/index">
                    <i class="fa fa-th"></i> <span>Campos</span>
                </a>
            </li>
            <li class="treeview">
                <a href="<?= Yii::$app->request->baseUrl; ?>/#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Charts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/charts/morris.html"><i
                                class="fa fa-angle-double-right"></i> Morris</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/charts/flot.html"><i class="fa fa-angle-double-right"></i>
                            Flot</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/charts/inline.html"><i
                                class="fa fa-angle-double-right"></i> Inline charts</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?= Yii::$app->request->baseUrl; ?>/#">
                    <i class="fa fa-laptop"></i>
                    <span>UI Elements</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/UI/general.html"><i class="fa fa-angle-double-right"></i>
                            General</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/UI/icons.html"><i class="fa fa-angle-double-right"></i>
                            Icons</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i>
                            Buttons</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i>
                            Sliders</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i>
                            Timeline</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?= Yii::$app->request->baseUrl; ?>/#">
                    <i class="fa fa-edit"></i> <span>Forms</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/forms/general.html"><i
                                class="fa fa-angle-double-right"></i> General Elements</a>
                    </li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/forms/advanced.html"><i
                                class="fa fa-angle-double-right"></i> Advanced
                            Elements</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl; ?>/pages/forms/editors.html"><i
                                class="fa fa-angle-double-right"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?= Yii::$app->request->baseUrl; ?>/#">
                    <i class="fa fa-table"></i> <span>Tables</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= $directoryAsset ?>/pages/tables/simple.html"><i
                                class="fa fa-angle-double-right"></i> Simple tables</a>
                    </li>
                    <li><a href="<?= $directoryAsset ?>/pages/tables/data.html"><i class="fa fa-angle-double-right"></i>
                            Data tables</a></li>
                </ul>
            </li>
            <li>
                <a href="<?= $directoryAsset ?>/pages/calendar.html">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <small class="badge pull-right bg-red">3</small>
                </a>
            </li>
            <li>
                <a href="<?= $directoryAsset ?>/pages/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <small class="badge pull-right bg-yellow">12</small>
                </a>
            </li>
            <li class="treeview">
                <a href="<?= $directoryAsset ?>/#">
                    <i class="fa fa-folder"></i> <span>Examples</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= $directoryAsset ?>/pages/examples/invoice.html">
                            <i class="fa fa-angle-double-right"></i> Invoice</a>
                    </li>
                    <li>
                        <a href="<?= $directoryAsset ?>/pages/examples/login.html"><i
                                class="fa fa-angle-double-right"></i> Login</a>
                    </li>
                    <li><a href="<?= $directoryAsset ?>/pages/examples/register.html"><i
                                class="fa fa-angle-double-right"></i> Register</a>
                    </li>
                    <li><a href="<?= $directoryAsset ?>/pages/examples/lockscreen.html"><i
                                class="fa fa-angle-double-right"></i> Lockscreen</a>
                    </li>
                    <li><a href="<?= $directoryAsset ?>/pages/examples/404.html"><i
                                class="fa fa-angle-double-right"></i> 404 Error</a></li>
                    <li><a href="<?= $directoryAsset ?>/pages/examples/500.html"><i
                                class="fa fa-angle-double-right"></i> 500 Error</a></li>
                    <li><a href="<?= $directoryAsset ?>/pages/examples/blank.html"><i
                                class="fa fa-angle-double-right"></i> Blank Page</a></li>
                </ul> -->
            </li>
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

