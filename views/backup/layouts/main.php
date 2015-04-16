<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript" charset="utf8" src="<?= Yii::$app->request->baseUrl; ?>/js/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Muli:300,400,400italic,300italic|Montserrat:700,400' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'options' => [
                    'class' => 'navegacion navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

            <div class="nopad">
                <p class="text-center">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/LogoFin50pxapp.png" alt="" style="width:90%" class="responsive">
                </p>
            <!-- <div class="collapse navbar-collapse navbar-ex1-collapse"> -->
                <?php 
                     echo Nav::widget([
                        'options' => ['class' => 'nav-pills nav-stacked'],
                        'items' => [
                            // ['label' => 'Inicio', 'url' => ['/site/index'], 'class'=>'button'],
                            ['label' => 'Procedimientos', 'url' => ['/procedimientos/index']],
                            ['label' => 'Pacientes', 'url' => ['/pacientes/index']],
                            ['label' => 'Médicos', 'url' => ['/medicos/index']],
                            ['label' => 'Eps', 'url' => ['/eps/index']],
                            ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                            
                        ],
                    ]);   
                 ?>                    
            </div>
        <div class="row">
            <div class="col-md-10 contenido">
                <?php // echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                <div class="col-md-12">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <!-- <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
