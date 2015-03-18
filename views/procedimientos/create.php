<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedimientos */

$this->title = 'Crear procedimiento';
$this->params['breadcrumbs'][] = ['label' => 'Procedimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimientos-create text-center">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 
        'paciente_model'=>$paciente_model,
        'ips_model'=>$ips_model,
        'ips_list'=>$ips_list,
    ]) ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        nombrePaciente('#documento', '#procedimientos-idpacientes', '#pacienteName');
    });
</script>
