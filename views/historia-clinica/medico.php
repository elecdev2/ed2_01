<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\DetailView;
    use kartik\select2\Select2;
    use yii\web\JsExpression;

    use app\models\ListasSistema;
    use app\models\Ciudades; 
    use app\models\AntecedentesPatologicos; 
    use app\models\HistoriaClinica; 
 ?>

<input type="text" hidden id="nombre_pac" value="<?=$nombre_pac?>" data-pac="<?=$paciente->id?>">


<div class="col-xs-3"> 
    <ul class="nav nav-tabs tabs-left">
      <li class="active"><a href="#paciente" data-toggle="tab">Perfil del paciente</a></li>
      <li><a href="#mot" data-toggle="tab">Motivo-Enfermedad actual</a></li>
      <li><a href="#ant_pa" data-toggle="tab">Antecedentes patologicos</a></li>
      <li><a href="#ant_fam" data-toggle="tab">Antecedentes familiares</a></li>
      <li><a href="#hab" data-toggle="tab">Habitos</a></li>
      <li><a href="#rev" data-toggle="tab">Revision por sistemas</a></li>
      <li><a href="#fis" data-toggle="tab">Examen físico</a></li>
      <li><a href="#exp" data-toggle="tab">Exploración regional</a></li>
      <li><a href="#an_im" data-toggle="tab">Análisis e impresión diagnostica</a></li>
      <li><a href="#rec" data-toggle="tab">Recomendaciones</a></li>
      <li><a href="#for" data-toggle="tab">Formulación</a></li>
      <li><a href="#arch" data-toggle="tab">Archivos</a></li>
    </ul>
</div>

<div class="col-xs-9">
    <div class="tab-content">
        
        <div class="tab-pane fade in active" id="paciente">
            <?= DetailView::widget([
                'model' => $paciente,
                'attributes' => [
                    // 'id',
                    [
                        'attribute'=>'identificacion',
                        'value'=>$paciente->tipo_identificacion.' '.$paciente->identificacion,
                    ],

                    [
                        'attribute'=>'nombre1',
                        'label'=>'Nombre',
                        'value'=>$paciente->nombre1.' '.$paciente->nombre2.' '.$paciente->apellido1.' '.$paciente->apellido2,
                    ],
                    // 'apellido1',
                    // 'nombre1',
                    // 'nombre2',
                    // 'apellido2',
                    'direccion',
                    'telefono',
                    'sexo',
                    'fecha_nacimiento',
                    [
                        'attribute'=>'tipo_usuario',
                        'label'=>'Tipo de usuario',
                        'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$paciente->tipo_usuario])->scalar(),
                    ],
                    [
                        'attribute'=>'tipo_residencia',
                        'label'=>'Tipo de residencia',
                        'value'=> ListasSistema::find()->select(['descripcion'])->where(['codigo'=>$paciente->tipo_residencia])->scalar(),
                    ],
                    // 'idclientes',
                    [
                        'attribute'=>'idciudad',
                        'label'=>'Ciudad',
                        'value'=>Ciudades::findOne($paciente->idciudad)->nombre,
                    ],
                    
                    [
                        'attribute'=>'ideps',
                        'label'=>'EPS',
                        'value'=>$paciente->ideps != null ? $paciente->ideps0->nombre : '',
                    ],
                    [
                        'attribute'=>'email',
                        'label'=>'Email',
                        'value'=>$paciente->email,
                    ],
                ],
            ]) ?>
        </div>

<!-- motivo -->
        <div class="tab-pane fade" id="mot">

            <?php $form_mot = ActiveForm::begin(['id' => 'motForm', 'validateOnType' => true, 'action'=>'new-mot']); ?>
                
                <?= $form_mot->field($motivo_e, 'id')->widget(Select2::classname(), [
                        'data'=>$motivo_l,
                        'language' => 'es',
                        'options' => ['name'=>'mot_enf','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#motiv').html(result[0]);
                                    $('#enfer').html(result[1]);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                
               <div class="content-disabled" id="motiv"></div>

                <?= $form_mot->field($motivo_e, 'motivo', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Motivo de consulta', 'cols'=>85, 'rows'=>5]) ?>

                <div class="content-disabled" id="enfer"></div>

                <?= $form_mot->field($motivo_e, 'enfermedad', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Enfermedad actual', 'cols'=>85, 'rows'=>5]) ?>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>

<!-- antecedentes patologicos -->
        <div class="tab-pane fade" id="ant_pa">
            <?php $form_pat = ActiveForm::begin(['id' => 'patForm', 'validateOnType' => true, 'action'=>'new-pat']); ?>

                <?= $form_pat->field($ant_pato_e, 'id')->widget(Select2::classname(), [
                        'data'=>$ant_pato_l,
                        'language' => 'es',
                        'options' => ['name'=>'ant_pat','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#antecedentes_pat').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>

                <div class="content-disabled" id="antecedentes_pat"></div>
                
                <div class="form-content">
                    <label for="antecedentespatologicos-infecciosos" class="col-sm-3">Infecciosos</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'infecciosos')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-enfermedades_mayores" class="col-sm-3">Enf. Mayores</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'enfermedades_mayores')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-hospitalarios" class="col-sm-3">Hospitalarios</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'hospitalarios')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-quirurgicos" class="col-sm-3">Quirurgicos</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'quirurgicos')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-alergias" class="col-sm-3">Alergias</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'alergias')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-traumaticos" class="col-sm-3">Traumaticos</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'traumaticos')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-ets" class="col-sm-3">ETS</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_pat->field($ant_pato_e, 'ets')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-otros" class="col-sm-3">Otros</label>
                    <?= $form_pat->field($ant_pato_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- antecedentes familiares -->
        <div class="tab-pane fade" id="ant_fam">
            <?php $form_fam = ActiveForm::begin(['id' => 'famForm', 'validateOnType' => true, 'action'=>'new-fam']); ?>

                <?= $form_fam->field($ant_fam_e, 'id')->widget(Select2::classname(), [
                        'data'=>$ant_fam_l,
                        'language' => 'es',
                        'options' => ['name'=>'ant_fam','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#antecendentes_fam').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="antecendentes_fam"></div>
                
                <div class="form-content">
                    <label for="antecedentesfamiliares-diabetes" class="col-sm-3">Diabetes</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'diabetes')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-hipertension" class="col-sm-3">Hipertension</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'hipertension')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-cardiopatia" class="col-sm-3">Cardiopatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'cardiopatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-hepatopatia" class="col-sm-3">Hepatopatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'hepatopatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-nefropatia" class="col-sm-3">Nefropatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'nefropatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-enf_mentales" class="col-sm-3">Enfermedades mentales</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'enf_mentales')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-asma" class="col-sm-3">Asma</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'asma')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-cancer" class="col-sm-3">Cancer</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'cancer')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-enf_alergicas" class="col-sm-3">Enfermedades alergicas</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_fam->field($ant_fam_e, 'enf_alergicas')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-otros" class="col-sm-3">Otros</label>
                    <?= $form_fam->field($ant_fam_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- Habitos -->
        <div class="tab-pane fade" id="hab">
            <?php $form_hab = ActiveForm::begin(['id' => 'habForm', 'validateOnType' => true, 'action'=>'new-hab']); ?>

                <?= $form_hab->field($habitos_e, 'id')->widget(Select2::classname(), [
                        'data'=>$habitos_l,
                        'language' => 'es',
                        'options' => ['name'=>'hab','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#habitos').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="habitos"></div>
                
                <div class="form-content">
                    <label for="habitos-alcohol" class="col-sm-3">Alcohol</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_hab->field($habitos_e, 'alcohol')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-tabaco" class="col-sm-3">Tabaco</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_hab->field($habitos_e, 'tabaco')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-drogas" class="col-sm-3">Drogas</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_hab->field($habitos_e, 'drogas')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-actividad_fisica" class="col-sm-3">Actividad física</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_hab->field($habitos_e, 'actividad_fisica')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-otros" class="col-sm-3">Otros</label>
                    <?= $form_hab->field($habitos_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>

<!-- Revision por sistemas -->
        <div class="tab-pane fade" id="rev">
            <?php $form_rev = ActiveForm::begin(['id' => 'revForm', 'validateOnType' => true, 'action'=>'new-rev']); ?>

                 <?= $form_rev->field($rev_sis_e, 'id')->widget(Select2::classname(), [
                        'data'=>$rev_sis_l,
                        'language' => 'es',
                        'options' => ['name'=>'rev','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#revision_sistemas').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>

                <div class="content-disabled" id="revision_sistemas"></div>

                <div class="form-content">
                    <label for="rev_sis-cardiorespiratorio" class="col-sm-3">Cardiorespiratorio</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'cardiorespiratorio')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-gastrointestinal" class="col-sm-3">gastrointestinal</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'gastrointestinal')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-endocrino" class="col-sm-3">Endocrino</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'endocrino')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-osteomuscular" class="col-sm-3">Osteomuscular</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'osteomuscular')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-nervioso" class="col-sm-3">Nervioso</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'nervioso')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-sensorial" class="col-sm-3">Sensorial</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'sensorial')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-psicosomatico" class="col-sm-3">Psicosomatico</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'psicosomatico')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-locomotor" class="col-sm-3">Locomotor</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_rev->field($rev_sis_e, 'locomotor')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- examen fisico -->
        <div class="tab-pane fade" id="fis">
            <?php $form_ex = ActiveForm::begin(['id' => 'exForm', 'validateOnType' => true, 'action'=>'new-ex']); ?>

                <?= $form_ex->field($exam_fis_e, 'id')->widget(Select2::classname(), [
                        'data'=>$exam_fis_l,
                        'language' => 'es',
                        'options' => ['name'=>'fis','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#examen_fisico').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="examen_fisico"></div>

                <?= $form_ex->field($exam_fis_e, 'peso')->textInput()->label('Peso (Kg)') ?>
                <?= $form_ex->field($exam_fis_e, 'estatura')->textInput()->label('Estatura (cm)') ?>
                <?= $form_ex->field($exam_fis_e, 'presion_arterial')->textInput(['maxlength' => 10])->label('Presión arterial (mm de Hg)') ?>
                <?= $form_ex->field($exam_fis_e, 'frec_respiratoria')->textInput()->label('Frecuencia respiratoria') ?>
                <?= $form_ex->field($exam_fis_e, 'pulso')->textInput()->label('Pulso') ?>
                <?= $form_ex->field($exam_fis_e, 'temperatura')->textInput()->label('Temperatura (°C)') ?>
                <?= $form_ex->field($exam_fis_e, 'complexion')->textInput(['maxlength' => 15])->label('Complexión') ?>

                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- exploracion regional -->
        <div class="tab-pane fade" id="exp">
            <?php $form_exp = ActiveForm::begin(['id' => 'expForm', 'validateOnType' => true, 'action'=>'new-exp']); ?>

                <?= $form_exp->field($exp_reg_e, 'id')->widget(Select2::classname(), [
                        'data'=>$exp_reg_l,
                        'language' => 'es',
                        'options' => ['name'=>'exp','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#exploracion_regional').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="exploracion_regional"></div>

                <div class="form-content">
                    <label for="expl_reg-cabeza" class="col-sm-3">Cabeza</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'cabeza')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-cuello" class="col-sm-3">Cuello</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'cuello')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-torax" class="col-sm-3">Torax</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'torax')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-abdomen" class="col-sm-3">Abdomen</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'abdomen')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-miembros" class="col-sm-3">Miembros</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'miembros')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-genitales" class="col-sm-3">Genitales</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form_exp->field($exp_reg_e, 'genitales')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- Analisis diagnostico -->
        <div class="tab-pane fade" id="an_im">

            <?php $form_an = ActiveForm::begin(['id' => 'anForm', 'validateOnType' => true, 'action'=>'new-an']); ?>
                <?= $form_an->field($analisis, 'id')->widget(Select2::classname(), [
                        'data'=>$analisis_l,
                        'language' => 'es',
                        'options' => ['name'=>'ana','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#analisis_diag').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="analisis_diag"></div>


                <?= $form_an->field($an_imp, 'id_cod')->widget(Select2::classname(), [
                        'language' => 'es',
                        'options' => [
                            'placeholder' => 'Seleccione una o mas opciones',
                            'multiple' => true,
                            'tags'=>true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Seleccione una o mas opciones',
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => 'cod-diag',
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(cod) { return cod.text; }'),
                            'templateSelection' => new JsExpression('function (cod) { return cod.text; }'),
                        ],
                    ])->label('Seleccione diagnostico(s)');
                ?>

                <?= $form_an->field($analisis, 'analisis')->textArea(['cols'=>85, 'rows'=>5, 'maxlength'=>true]) ?>
                
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                 <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

<!-- Recomendaciones -->
        <div class="tab-pane fade" id="rec">
             <?php $form_rec = ActiveForm::begin(['id' => 'reForm', 'validateOnType' => true, 'action'=>'new-rec']); ?>

                <?= $form_rec->field($recom_e, 'id')->widget(Select2::classname(), [
                        'data'=>$recom_l,
                        'language' => 'es',
                        'options' => ['name'=>'rec','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#recomendaciones').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="recomendaciones"></div>

                <?= $form_rec->field($recom_e, 'recomendaciones', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Nueva recomendación', 'cols'=>85, 'rows'=>5]) ?>
             
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>

             <?php ActiveForm::end(); ?>
        </div>

<!-- Formulacion -->
        <div class="tab-pane fade" id="for">
             <?php $form_for = ActiveForm::begin(['id' => 'ForForm', 'validateOnType' => true, 'action'=>'new-for']); ?>

                <?= $form_for->field($formula_e, 'id')->widget(Select2::classname(), [
                        'data'=>$formula_l,
                        'language' => 'es',
                        'options' => ['name'=>'for','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#formulacion').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="formulacion"></div>

                <?= $form_for->field($formula_e, 'formulacion', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Nueva formulación', 'cols'=>85, 'rows'=>5]) ?>
             
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
                </div>

             <?php ActiveForm::end(); ?>
        </div>

<!-- Archivos -->
        <div class="tab-pane fade" id="arch">

             <?php $form_ar = ActiveForm::begin(['id' => 'archForm', 'options' => ['enctype' => 'multipart/form-data'], 'action' => 'upload']) ?>
                
                <?= $form_ar->field($archivo_historial, 'id')->widget(Select2::classname(), [
                        'data'=>$archivo_historial_l,
                        'language' => 'es',
                        'options' => ['name'=>'arch','placeholder' => 'Seleccione una opción'],
                        'pluginEvents'=>[
                            "change" => "function() {
                                $.post('../historia-clinica/consultar-fechas', {id: $(this).attr('name'), hc: $(this).val()}).done(function(result) {
                                    $('#archivos_h').html(result);
                                });
                            }",
                        ]
                    ])->label('Seleccione fecha');
                ?>
                <div class="content-disabled" id="archivos_h"></div>

                <?= $form_ar->field($archivo, 'files[]')->fileInput(['multiple' => true, 'accept' => '*'])->label('Cargar archivo(s)') ?>
             
                <input type="text" hidden name="historia_cli" value="<?=$hc?>">

                <div class='col-sm-12 text-center'>
                    <?= Html::submitButton('<i class="add icon-guardar"></i>Cargar', ['class' =>'btn btn-success']) ?>
                </div>

             <?php ActiveForm::end(); ?>
        </div>

    </div>
</div> 

<?php 
    $js = <<<SCRIPT

$('form').on('beforeSubmit', function(e)
{
    var \$form = $(this);
    var data = new FormData($(this)[0]);

    $.ajax({
        url : \$form.attr("action"),
        type : "post",
        data : data,
        processData: false,
        contentType: false,
        cache : false,
        success : function(result)
        {
            switch (result) 
            {
                case '0':
                    notification('Error al guardar', 2);
                    break;
                case '1':
                    notification('Se guardaron los cambios', 1);
                    break;
                case '2':
                    notification('Formato de archivo inválido', 2);
                    break;          
            }
        },
        fail : function(result)
        {
            notification('Server error', 2);
        }
    });

    // $.post(
    //     \$form.attr("action"), 
    //     x
    // )
    // .done(function(result) {
    //     console.log(result);
    //     // switch (result) 
    //     // {
    //     //     case '1':
    //     //         notification('Se guardaron los cambios', 1);
    //     //         break;
    //     //     case '0':
    //     //         notification('Error al guardar', 2);
    //     //         break;            
    //     // }
        
    //     // btn.attr('disabled', true);
    // })
    // .fail(function(){
    //     notification('Server error', 2);
    //     // console.log("Server error");
    // });
    return false;
});

SCRIPT;
$this->registerJs($js);

?>