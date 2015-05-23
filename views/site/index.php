<?php
/* @var $this yii\web\View */
$this->title = 'Clapp';

?>
<div class="site-index">

     <div class="span-23 showgrid">
        <div class="dashboardIcons span-16">

            <a href="<?= Yii::$app->request->baseUrl; ?>/procedimientos/index"  style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/procedimientos.png" alt="Estudios"  />
                    <div class="dashIconText">Estudios</div>
                </div>
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/pacientes/index" style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>" >
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/pacientes.png" alt="Pacientes"  />
                    <div class="dashIconText">Pacientes</div>
                </div>
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/medicos/index"  style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/medicos.png" alt="Médicos"  />
                    <div class="dashIconText">Médicos</div>
                </div>
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/eps/index" style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/eps.png" alt="EPS"  />
                    <div class="dashIconText ">EPS</div>
                </div>
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/procedimientos/indexrep.html"  style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/reportes.png" alt="Reportes RIP"  />
                    <div class="dashIconText">Reportes</div>
                </div> 
            </a> 

            <a href="<?= Yii::$app->request->baseUrl; ?>/procedimientos/facturacion.html" style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/facturacion.png" alt="Facturación"  />
                    <div class="dashIconText">Facturación</div>
                </div> 
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/usuarios/index"  style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/usuarios.png" alt="Usuarios"  />
                    <div class="dashIconText">Usuarios</div>
                </div>
            </a>

            <a href="<?= Yii::$app->request->baseUrl; ?>/clientes/index"  style="<?= Yii::$app->user->can("admin")?'':'display:none' ?>">
                <div class="dashIcon span-3">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/iconos-clapp/administracion.png" alt="Administración"  />
                    <div class="dashIconText">Administración</div>
                </div> 
            </a>  

        </div>
    </div>
</div>
