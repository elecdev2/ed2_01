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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Procedimientos', 'url' => ['/procedimientos/index']],
                    ['label' => 'Pacientes', 'url' => ['/pacientes/index']],
                    ['label' => 'Médicos', 'url' => ['/medicos/index']],
                    ['label' => 'Eps', 'url' => ['/eps/index']],
                    ['label' => 'Administración', 'url' => ['/site/admin']],
                    ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
        	
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <h1>Panel administrativo</h1>
            <!-- <div class="col-md-12 nopad"><br>
                 <div class="col-md-3 nopad">
                    <div class="nav-stacked">
                      <?=Html::a('Clientes', ['clientes/index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Ips\'s', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Tipos de servicio', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Listas del sistema', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Campos', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Especialidades', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Perfiles', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Informes', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Estudios', ['index'], ['class' => 'list-group-item text-center']) ?>
                      <?=Html::a('Resultados', ['index'], ['class' => 'list-group-item text-center']) ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <h3>Contenido</h3>  
                </div>
            </div> -->
            <div class="col-md-12 nopad"><br>
                 <div class="col-md-2 nopad">
                    <ul class="nav nav-pills nav-stacked">
                      <li role="presentation"><?=Html::a('Clientes', ['clientes/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Ips\'s', ['ips/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Tipos de servicio', ['tipos-servicio/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Listas del sistema', ['listas-sistema/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Campos', ['campos/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Especialidades', ['especialidades/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Perfiles', ['#'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Informes', ['informes/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Estudios', ['estudios/index'], ['class' => 'enlace']) ?></li>
                      <li role="presentation"><?=Html::a('Resultados', ['#'], ['class' => 'enlace']) ?></li>
                    </ul>
                </div>

                <div class="col-md-10">
                    <?= $content ?>                 
                </div>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('ul li a.enlace').on('click', function(event) {
			$('.active').removeClass('active');
			$(this).parent('li').addClass('active');
		});
	});
</script>