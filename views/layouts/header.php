<?php
use \app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<header class="header">

<?php //= Html::a('', '', ['class' => 'logo']) ?>

<nav class="navbar navbar-fixed-top" role="navigation">

<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
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
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i>
            <span><?= @Yii::$app->user->identity->username ?> <i class="caret"></i></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header bg-light-blue">
                <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>

                <p>
                    <?= @Yii::$app->user->identity->username ?> - Perfil
                    <!-- <small>Member since Nov. 2012</small> -->
                </p>
            </li>
            <!-- Menu Body -->
            <!-- <li class="user-body">
              
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Mi perfil</a>
                </div>
                <div class="pull-right">
                    <?= Html::a(
                            'Cerrar sesión',
                            ['/site/logout'],
                            ['data-method' => 'post','class'=>'btn btn-default btn-flat']
                        ) ?>
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
