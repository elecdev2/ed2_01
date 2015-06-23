<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Resultados';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="text-center"><?= Html::tag('h3', (isset($m)) ? 'Error: verifique que su número de identificación y de muestra esten correctamente escritos.' : '' ,['class'=> isset($m) ? 'help-block blockError' : '']);?></div>
<div id="box_bg">
    <div class="logincontent">

            <div style="margin:20px 0px 40px 0px">
                <center>
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/logoLogin.png" style="width:95%">
                </center>
            </div>
    
            <?php $form = ActiveForm::begin([
                'id' => 'result-form',
                'options' => ['class' => 'form-horizontal'],
                'action'=>'resultados',
                // 'fieldConfig' => [
                //     'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                //     'labelOptions' => ['class' => 'col-lg-1 control-label'],
                // ],
            ]); ?>
        
            <div class='result'>
                <?=Html::input('text', 'identificacion',!empty($_GET) ? $_GET['i'] : '', ['required'=>'', 'class'=>'form-control', 'placeHolder'=>'Identificación'])  ?>
            </div>

             <div class='result'>
                <?=Html::input('text', 'muestra',!empty($_GET) ? $_GET['e'] : '', ['required'=>'', 'class'=>'form-control', 'placeHolder'=>'Número de muestra'])  ?>
            </div>


            <div class="loginlabel">
                <span class="btnlogin buttons">
                    <?= Html::submitButton('Ver resultados', ['class' => '', 'name' => 'result-button']) ?>
                </span>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

