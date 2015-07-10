<?php
use app\models\usuarios;
use app\models\Medicos;

use \app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<header class="header">

<nav class="navbar navbar-fixed-top" role="navigation">

<a href="<?= Yii::$app->homeUrl?>" class="logo" style="background-color:#2e394d;"><img src="<?= Yii::$app->request->baseUrl; ?>/images/LogoFin50pxapp.png" alt="" class="logo-lg"></a>
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <i class="btn-toggle"></i>
</a>

<div class="navbar-right">

<ul class="nav navbar-nav">

<?php
if (Yii::$app->user->isGuest) {
    ?>
    <li class="footer">
        <?= Html::a('Login', ['/site/login']) ?>
    </li>
<?php
} else {
    ?>
    <li class="dropdown user user-menu">
        <?php $usuario = Usuarios::findOne(Yii::$app->user->id) ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 4px 15px;">
            <i class="glyphicon" style="width: 40px;"><img src="<?= Yii::$app->request->baseUrl; ?>/images/fotos_perfiles/<?=$usuario->foto?>" class="" alt="Imagen de usuario"/></i>
            <span style="font-size:17px; vertical-align: sub;"><?= $usuario->nombre ?> <i class="fa fa-caret-down"></i></span>
        </a>
        <ul class="dropdown-menu menu-avatar" style="width: 350px;">
            <!-- User image -->
            <li class="user-header bg-light-blue">
                <img src="<?= Yii::$app->request->baseUrl; ?>/images/fotos_perfiles/<?=$usuario->foto?>" class="" alt="Imagen de usuario" style="width: 140px;height: 140px; border:none;"/>
                <div class="texto-avatar">
                    <p><?= $usuario->nombre ?></p>
                    <?php if(\Yii::$app->user->can('medico')){ ?>
                        <p><?=Medicos::findOne($usuario->idmedicos)->idespecialidades0->nombre ?></p>
                    <?php } ?>
                </div>
            </li>
            <!-- Menu Body -->
            <!-- <li class="user-body">
              
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="botones-footer">
                    <?= Html::a(
                            '<i class="logOut"></i>Cerrar sesión',
                            ['/site/logout'],
                            ['data-method' => 'post','class'=>'btn']
                        ) ?>
                </div>

                <div class="botones-footer">
                    <?= Html::a('<i class="usuarioAv"></i>Mi perfil', ['site/update', 'id'=>Yii::$app->user->id], ['class'=>'btn']) ?>
                </div>
            </li>
        </ul>
    </li><?php
}
?>
<!-- User Account: style can be found in dropdown.less -->

</ul>
</div>
</nav>
</header>
