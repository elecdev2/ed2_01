<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
        'wrapper-black',
        ['content' => $content]
    );
} else {
    dmstr\web\AdminLteAsset::register($this);
    \app\assets\AppAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower') . '/admin-lte';
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script type="text/javascript" charset="utf8" src="<?= Yii::$app->request->baseUrl; ?>/js/jquery.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Muli:300,400,400italic,300italic|Montserrat:700,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl; ?>/css/screen.css">
        <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl; ?>/css/estilos.css">
        <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl; ?>/css/main.css">
        <?= Html::csrfMetaTags() ?>
        <!-- <title><?= Html::encode($this->title) ?></title> -->
        <?php $this->head() ?>
    </head>
    <body class="skin-black">
    <?php $this->beginBody() ?>

    <?= $this->render(
        'header.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <div class="row-offcanvas">


        <div class="wrapper container" id="page" style="padding-top:5%">
            <div class="bginicio">
                <?= $content; ?>
            </div>
            <div class="push"></div>
        </div>
        <footer>
            <div class ="footer" style="float:left; display:inline-block;padding:15px 0px 15px 25px">Copyright &copy; Elecsis <?= date('Y'); ?> • Todos los derechos reservados.</div>
                <div style="float:right; display:inline-block;padding:10px 25px 8px 0px"> 
                    <a href="http://www.elecsis.co" target="_blank">
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/logoElecsis.png" width="86px" height="25px">
                    </a>    
                </div>     
            <div style="float:right; display:inline-block;padding:15px 0px">Un producto de</div>
        </footer>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>

