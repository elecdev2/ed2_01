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
		<script type="text/javascript" charset="utf8" src="<?= Yii::$app->request->baseUrl; ?>/js/jquery.min.js"></script>
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>

	<body>
		<?php $this->beginBody() ?>
		<div class="container"><br><br>
			<?= $content; ?>
		</div>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>