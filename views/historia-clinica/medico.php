<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\DetailView;
    use kartik\select2\Select2;

    use app\models\ListasSistema;
    use app\models\Ciudades; 
    use app\models\AntecedentesPatologicos; 
 ?>

<input type="text" hidden id="nombre_pac" value="<?=$nombre_pac?>">


<div class="col-xs-3"> <!-- required for floating -->
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
    </ul>
</div>

<?php $form = ActiveForm::begin(['id' => 'historiaForm', 'validateOnType' => true, 'enableClientValidation' => true, 'action'=>'update-historia']); ?>
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
                
                <div class="content-disabled" >
                    <?php foreach ($motivo_l as $key => $value) { ?>
                        <p><?=$value['motivo'] ?></p>
                    <?php } ?>                    
                </div>
               

                <?= $form->field($motivo_e, 'motivo', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Motivo de consulta', 'cols'=>85, 'rows'=>5]) ?>

                <div class="content-disabled" >
                    <?php foreach ($motivo_l as $key => $value) { ?>
                        <p><?=$value['enfermedad'] ?></p>
                    <?php } ?>
                </div>

                <?= $form->field($motivo_e, 'enfermedad', ['template'=>"{input}{error}"])->textArea(['placeholder'=>'Enfermedad actual', 'cols'=>85, 'rows'=>5]) ?>

            </div>

<!-- antecedentes patologicos -->
            <div class="tab-pane fade" id="ant_pa">
                <div class="content-disabled" >
                   <?= DetailView::widget([
                        'model' => $ant_pato_l,
                        'attributes' => [
                            [
                                'attribute'=>'infecciosos',
                                'value'=>substr($ant_pato_l->infecciosos,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->infecciosos,2),
                            ],
                            [
                                'attribute'=>'enfermedades_mayores',
                                'value'=>substr($ant_pato_l->enfermedades_mayores,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->enfermedades_mayores,2),
                            ],
                            [
                                'attribute'=>'hospitalarios',
                                'value'=>substr($ant_pato_l->hospitalarios,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->hospitalarios,2),
                            ],
                            [
                                'attribute'=>'quirurgicos',
                                'value'=>substr($ant_pato_l->quirurgicos,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->quirurgicos,2),
                            ],
                            [
                                'attribute'=>'alergias',
                                'value'=>substr($ant_pato_l->alergias,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->alergias,2),
                            ],
                            [
                                'attribute'=>'traumaticos',
                                'value'=>substr($ant_pato_l->traumaticos,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->traumaticos,2),
                            ],
                            [
                                'attribute'=>'ets',
                                'value'=>substr($ant_pato_l->ets,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_pato_l->ets,2),
                            ],
                            [
                                'attribute'=>'otros',
                                'value'=>$ant_pato_l->otros,
                            ],

                        ],
                    ]) ?>
                </div>
                
                <div class="form-content">
                    <label for="antecedentespatologicos-infecciosos" class="col-sm-3">Infecciosos</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'infecciosos')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-enfermedades_mayores" class="col-sm-3">Enf. Mayores</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'enfermedades_mayores')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-hospitalarios" class="col-sm-3">Hospitalarios</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'hospitalarios')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-quirurgicos" class="col-sm-3">Quirurgicos</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'quirurgicos')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-alergias" class="col-sm-3">Alergias</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'alergias')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-ets" class="col-sm-3">ETS</label>
                    <?=Html::dropDownList('sino[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_pato_e, 'ets')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentespatologicos-otros" class="col-sm-3">Otros</label>
                    <?= $form->field($ant_pato_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>
                
            </div>

<!-- antecedentes familiares -->
            <div class="tab-pane fade" id="ant_fam">
                <div class="content-disabled">
                   <?= DetailView::widget([
                        'model' => $ant_fam_l,
                        'attributes' => [
                            [
                                'attribute'=>'diabetes',
                                'value'=>substr($ant_fam_l->diabetes,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2): 'No - '. substr($ant_fam_l->diabetes,2),
                            ],
                            [
                                'attribute'=>'hipertension',
                                'value'=>substr($ant_fam_l->hipertension,0,1) == '1' ? 'Si - '. substr($ant_fam_l->hipertension,2) : 'No - '. substr($ant_fam_l->hipertension,2),
                            ],
                            [
                                'attribute'=>'cardiopatia',
                                'value'=>substr($ant_fam_l->cardiopatia,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->cardiopatia,2),
                            ],
                            [
                                'attribute'=>'hepatopatia',
                                'value'=>substr($ant_fam_l->hepatopatia,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->hepatopatia,2),
                            ],
                            [
                                'attribute'=>'nefropatia',
                                'value'=>substr($ant_fam_l->nefropatia,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->nefropatia,2),
                            ],
                            [
                                'attribute'=>'enf_mentales',
                                'value'=>substr($ant_fam_l->enf_mentales,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->enf_mentales,2),
                            ],
                            [
                                'attribute'=>'asma',
                                'value'=>substr($ant_fam_l->asma,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->asma,2),
                            ],
                            [
                                'attribute'=>'cancer',
                                'value'=>substr($ant_fam_l->cancer,0,1) == '1' ? 'Si - '. substr($ant_fam_l->diabetes,2) : 'No - '. substr($ant_fam_l->cancer,2),
                            ],
                            [
                                'attribute'=>'enf_alergicas',
                                'value'=>substr($ant_fam_l->enf_alergicas,0,1) == '1' ? 'Si - ': 'No - '. substr($ant_fam_l->enf_alergicas,2),
                            ],
                            [
                                'attribute'=>'otros',
                                'value'=>$ant_fam_l->otros,
                            ],
                        ],
                    ]) ?>
                </div>
                
                <div class="form-content">
                    <label for="antecedentesfamiliares-diabetes" class="col-sm-3">Diabetes</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'diabetes')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-hipertension" class="col-sm-3">Hipertension</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'hipertension')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-cardiopatia" class="col-sm-3">Cardiopatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'cardiopatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-hepatopatia" class="col-sm-3">Hepatopatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'hepatopatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-nefropatia" class="col-sm-3">Nefropatia</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'nefropatia')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-enf_mentales" class="col-sm-3">Enfermedades mentales</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'enf_mentales')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-asma" class="col-sm-3">Asma</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'asma')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-cancer" class="col-sm-3">Cancer</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'cancer')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-enf_alergicas" class="col-sm-3">Enfermedades alergicas</label>
                    <?=Html::dropDownList('sino_ant_fam[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($ant_fam_e, 'enf_alergicas')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="antecedentesfamiliares-otros" class="col-sm-3">Otros</label>
                    <?= $form->field($ant_fam_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>

            </div>

<!-- Habitos -->
            <div class="tab-pane fade" id="hab">
                <div class="content-disabled">
                    <?= DetailView::widget([
                        'model' => $habitos_l,
                        'attributes' => [
                            [
                                'attribute'=>'alcohol',
                                'value'=>substr($habitos_l->alcohol,0,1) == '1' ? 'Si - '. substr($habitos_l->alcohol,2): 'No - '. substr($habitos_l->alcohol,2),
                            ],
                            [
                                'attribute'=>'tabaco',
                                'value'=>substr($habitos_l->tabaco,0,1) == '1' ? 'Si - '. substr($habitos_l->tabaco,2) : 'No - '. substr($habitos_l->tabaco,2),
                            ],
                            [
                                'attribute'=>'drogas',
                                'value'=>substr($habitos_l->drogas,0,1) == '1' ? 'Si - '. substr($habitos_l->drogas,2) : 'No - '. substr($habitos_l->drogas,2),
                            ],
                            [
                                'attribute'=>'actividad_fisica',
                                'value'=>substr($habitos_l->actividad_fisica,0,1) == '1' ? 'Si - '. substr($habitos_l->actividad_fisica,2) : 'No - '. substr($habitos_l->actividad_fisica,2),
                            ],
                            [
                                'attribute'=>'otros',
                                'value'=>$habitos_l->otros,
                            ],
                        ],
                    ]) ?>
                </div>
                
                <div class="form-content">
                    <label for="habitos-alcohol" class="col-sm-3">Alcohol</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($habitos_e, 'alcohol')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-tabaco" class="col-sm-3">Tabaco</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($habitos_e, 'tabaco')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-drogas" class="col-sm-3">Drogas</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($habitos_e, 'drogas')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-actividad_fisica" class="col-sm-3">Actividad física</label>
                    <?=Html::dropDownList('sino_habitos[]','',['1'=>'Si', '0'=>'No'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($habitos_e, 'actividad_fisica')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="habitos-otros" class="col-sm-3">Otros</label>
                    <?= $form->field($habitos_e, 'otros')->textArea(['cols'=>85, 'rows'=>4,])->label('') ?>
                </div>

            </div>
<!-- Revision por sistemas -->
            <div class="tab-pane fade" id="rev">
                <div class="content-disabled">
                    <?= DetailView::widget([
                        'model' => $rev_sis_l,
                        'attributes' => [
                            [
                                'attribute'=>'cardiorespiratorio',
                                'value'=>substr($rev_sis_l->cardiorespiratorio,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->cardiorespiratorio,2): 'Irregular - '. substr($rev_sis_l->cardiorespiratorio,2),
                            ],
                            [
                                'attribute'=>'gastrointestinal',
                                'value'=>substr($rev_sis_l->gastrointestinal,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->gastrointestinal,2) : 'Irregular - '. substr($rev_sis_l->gastrointestinal,2),
                            ],
                            [
                                'attribute'=>'endocrino',
                                'value'=>substr($rev_sis_l->endocrino,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->endocrino,2) : 'Irregular - '. substr($rev_sis_l->endocrino,2),
                            ],
                            [
                                'attribute'=>'osteomuscular',
                                'value'=>substr($rev_sis_l->osteomuscular,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->osteomuscular,2) : 'Irregular - '. substr($rev_sis_l->osteomuscular,2),
                            ],
                            [
                                'attribute'=>'nervioso',
                                'value'=>substr($rev_sis_l->nervioso,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->nervioso,2) : 'Irregular - '. substr($rev_sis_l->nervioso,2),
                            ],
                            [
                                'attribute'=>'sensorial',
                                'value'=>substr($rev_sis_l->sensorial,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->sensorial,2) : 'Irregular - '. substr($rev_sis_l->sensorial,2),
                            ],
                            [
                                'attribute'=>'psicosomatico',
                                'value'=>substr($rev_sis_l->psicosomatico,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->psicosomatico,2) : 'Irregular - '. substr($rev_sis_l->psicosomatico,2),
                            ],
                            [
                                'attribute'=>'locomotor',
                                'value'=>substr($rev_sis_l->locomotor,0,1) == '1' ? 'Normal - '. substr($rev_sis_l->locomotor,2) : 'Irregular - '. substr($rev_sis_l->locomotor,2),
                            ],
                        ],
                    ]) ?>
                </div>

                <div class="form-content">
                    <label for="rev_sis-cardiorespiratorio" class="col-sm-3">Cardiorespiratorio</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'cardiorespiratorio')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-gastrointestinal" class="col-sm-3">gastrointestinal</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'gastrointestinal')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-endocrino" class="col-sm-3">Endocrino</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'endocrino')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-osteomuscular" class="col-sm-3">Osteomuscular</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'osteomuscular')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-nervioso" class="col-sm-3">Nervioso</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'nervioso')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-sensorial" class="col-sm-3">Sensorial</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'sensorial')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-psicosomatico" class="col-sm-3">Psicosomatico</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'psicosomatico')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                 <div class="form-content">
                    <label for="rev_sis-locomotor" class="col-sm-3">Locomotor</label>
                    <?=Html::dropDownList('sino_rev_sis[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($rev_sis_e, 'locomotor')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
            </div>
<!-- examen fisico -->
            <div class="tab-pane fade" id="fis">
                <div class="content-disabled">
                    <?= DetailView::widget([
                        'model' => $exam_fis_l,
                        'attributes' => [
                            [
                                'attribute'=>'peso',
                                'value'=>$exam_fis_l->peso.' Kg',
                            ],
                            [
                                'attribute'=>'estatura',
                                'value'=>$exam_fis_l->estatura.' cm',
                            ],
                            [
                                'attribute'=>'presion_arterial',
                                'value'=>$exam_fis_l->presion_arterial.' mm de Hg',
                            ],
                            [
                                'attribute'=>'frec_respiratoria',
                                'value'=>$exam_fis_l->frec_respiratoria,
                            ],
                            [
                                'attribute'=>'pulso',
                                'value'=>$exam_fis_l->pulso,
                            ],
                            [
                                'attribute'=>'temperatura',
                                'value'=>$exam_fis_l->temperatura. ' °C',
                            ],
                            [
                                'attribute'=>'complexion',
                                'value'=>$exam_fis_l->complexion,
                            ],
                        ],
                    ]) ?>
                </div>

                <?= $form->field($exam_fis_e, 'peso')->textInput()->label('Peso (Kg)') ?>
                <?= $form->field($exam_fis_e, 'estatura')->textInput()->label('Estatura (cm)') ?>
                <?= $form->field($exam_fis_e, 'presion_arterial')->textInput(['maxlength' => 10])->label('Presión arterial (mm de Hg)') ?>
                <?= $form->field($exam_fis_e, 'frec_respiratoria')->textInput()->label('Frecuencia respiratoria') ?>
                <?= $form->field($exam_fis_e, 'pulso')->textInput()->label('Pulso') ?>
                <?= $form->field($exam_fis_e, 'temperatura')->textInput()->label('Temperatura (°C)') ?>
                <?= $form->field($exam_fis_e, 'complexion')->textInput(['maxlength' => 15])->label('Complexión') ?>
            </div>
<!-- exploracion regional -->
            <div class="tab-pane fade" id="exp">
                <div class="content-disabled">
                    <?= DetailView::widget([
                        'model' => $exp_reg_l,
                        'attributes' => [
                            [
                                'attribute'=>'cabeza',
                                'value'=>substr($exp_reg_l->cabeza,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->cabeza,2): 'Irregular - '. substr($exp_reg_l->cabeza,2),
                            ],
                            [
                                'attribute'=>'cuello',
                                'value'=>substr($exp_reg_l->cuello,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->cuello,2) : 'Irregular - '. substr($exp_reg_l->cuello,2),
                            ],
                            [
                                'attribute'=>'torax',
                                'value'=>substr($exp_reg_l->torax,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->torax,2) : 'Irregular - '. substr($exp_reg_l->torax,2),
                            ],
                            [
                                'attribute'=>'abdomen',
                                'value'=>substr($exp_reg_l->abdomen,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->abdomen,2) : 'Irregular - '. substr($exp_reg_l->abdomen,2),
                            ],
                            [
                                'attribute'=>'miembros',
                                'value'=>substr($exp_reg_l->miembros,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->miembros,2) : 'Irregular - '. substr($exp_reg_l->miembros,2),
                            ],
                            [
                                'attribute'=>'genitales',
                                'value'=>substr($exp_reg_l->genitales,0,1) == '1' ? 'Normal - '. substr($exp_reg_l->genitales,2) : 'Irregular - '. substr($exp_reg_l->genitales,2),
                            ],
                        ],
                    ]) ?>
                </div>

                <div class="form-content">
                    <label for="expl_reg-cabeza" class="col-sm-3">Cabeza</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'cabeza')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-cuello" class="col-sm-3">Cuello</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'cuello')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-torax" class="col-sm-3">Torax</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'torax')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-abdomen" class="col-sm-3">Abdomen</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'abdomen')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-miembros" class="col-sm-3">Miembros</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'miembros')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>
                <div class="form-content">
                    <label for="expl_reg-genitales" class="col-sm-3">Genitales</label>
                    <?=Html::dropDownList('sino_expl[]','',['1'=>'Normal', '0'=>'Irregular'], ['prompt'=>'Seleccione', 'class'=>'col-sm-3']) ?>
                    <?= $form->field($exp_reg_e, 'genitales')->textArea(['cols'=>85, 'rows'=>2,])->label('') ?>
                </div>

            </div>

            <div class="tab-pane fade" id="an_im">

                <div class="form-group field-antecedentespatologicos-infecciosos">
                    <label class="control-label" for="">Diagnostico Codigos CIE10</label>
                   
                </div>
                <?= $form->field($analisis, 'analisis')->textArea(['cols'=>85, 'rows'=>5, 'maxlength'=>true]) ?>
            </div>

            <div class='col-sm-12 text-center'>
                <?= Html::submitButton('<i class="add icon-guardar"></i>Guardar', ['class' =>'btn btn-success']) ?>
            </div>
        </div>
    </div> 

    
<?php ActiveForm::end(); ?>