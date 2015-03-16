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
                    'class' => 'navbar-inverse navbar-fixed-top',
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

        <div class="container-fluid">
            <div class="col-md-3" style="width: 250px;">
                <img src="http://www.clapp.com.co/wp-content/uploads/2014/12/LogoFin_Logo50px.png" alt="" class="responsive"><br><br>
                <?php 
                     echo Nav::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'items' => [
                            ['label' => 'Inicio', 'url' => ['/site/index']],
                            ['label' => 'Procedimientos', 'url' => ['/procedimientos/index']],
                            ['label' => 'Pacientes', 'url' => ['/pacientes/index']],
                            ['label' => 'Médicos', 'url' => ['/medicos/index']],
                            ['label' => 'Eps', 'url' => ['/eps/index']],
                            ['label' => 'Administración', 'url' => ['/clientes/index']],
                            ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                            
                        ],
                    ]);   
                 ?>
            </div>
            <div class="col-md-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
