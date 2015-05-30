<?php
/* @var $this yii\web\View */
$this->title = 'Clapp';

?>
<div class="site-index">

     <div class="span-23 showgrid">
        <div class="dashboardIcons span-16">
            
            <?php if(Yii::$app->user->can('auxiliar') || Yii::$app->user->can('medico')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/procedimientos/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/procedimientosIndex.png" alt="Estudios"  />
                        <div class="dashIconText">Estudios</div>
                    </div>
                </a>
            <?php } ?>    
            
            <?php if(Yii::$app->user->can('auxiliar') || Yii::$app->user->can('medico')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/pacientes/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/pacientesIndex.png" alt="Pacientes"  />
                        <div class="dashIconText">Pacientes</div>
                    </div>
                </a>
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/medicos/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/medicosIndex.png" alt="Médicos"  />
                        <div class="dashIconText">Médicos</div>
                    </div>
                </a>
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/eps/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/epsIndex.png" alt="EPS"  />
                        <div class="dashIconText ">EPS</div>
                    </div>
                </a>
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/reportes/rips">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/reportesIndex.png" alt="Reportes RIP"  />
                        <div class="dashIconText">Reportes</div>
                    </div> 
                </a> 
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/facturas/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/facturacionIndex.png" alt="Facturación"  />
                        <div class="dashIconText">Facturación</div>
                    </div> 
                </a>
            <?php } ?>

            <?php if(Yii::$app->user->can('admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/usuarios/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/usuariosIndex.png" alt="Usuarios"  />
                        <div class="dashIconText">Usuarios</div>
                    </div>
                </a>
            <?php } ?>

            <?php if(Yii::$app->user->can('super_admin')){ ?>
                <a href="<?= Yii::$app->request->baseUrl; ?>/clientes/index">
                    <div class="dashIcon span-3">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos/administracionIndex.png" alt="Administración"  />
                        <div class="dashIconText">Administración</div>
                    </div> 
                </a>  
            <?php } ?>
        </div>
    </div>
</div>
