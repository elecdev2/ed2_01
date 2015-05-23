<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="box_bg">
    <div class="logincontent">

            <div style="margin:20px 0px 40px 0px">
                <center>
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/logoLogin.png" style="width:95%">
                </center>
            </div>
    
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>
        
            <div class="">
                <?= $form->field($model, 'username', ['template'=>"<div class='col-md-12'>{input}</div>\n<div class=\"col-md-10\">{error}</div>"])->textInput(['placeHolder'=>'Usuario']) ?>
            </div>

            <div class="">
                <?= $form->field($model, 'password', ['template'=>"<div class='col-md-12'>{input}</div>\n<div class=\"col-md-10\">{error}</div>"])->passwordInput(['placeHolder'=>'Contraseña'])?>
            </div>

            <?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox()->label('Recuerdame') ?>

            <div class="loginlabel">
                <span class="btnlogin buttons">
                    <?= Html::submitButton('Iniciar sesión', ['class' => '', 'name' => 'login-button']) ?>
                </span>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

