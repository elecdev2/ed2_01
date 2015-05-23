<?php

use yii\helpers\Html;
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl; ?>/css/estilos.css">
		<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl; ?>/css/screen.css">
		<script type="text/javascript" charset="utf8" src="<?= Yii::$app->request->baseUrl; ?>/js/jquery.min.js"></script>
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>

	<body>
		<?php $this->beginBody() ?>
		<div class="containerLogin wrapperLogin">            
            <div class="bglogin">
				<?= $content; ?>
			</div>
			<div class="pushLogin"></div>
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

		<?php $this->endBody() ?>
	</body>

</html>
<?php $this->endPage() ?>