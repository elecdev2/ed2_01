<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>'cardiorespiratorio',
                                'value'=>substr($model->cardiorespiratorio,0,1) == '1' ? 'Normal - '. substr($model->cardiorespiratorio,2): 'Irregular - '. substr($model->cardiorespiratorio,2),
                            ],
                            [
                                'attribute'=>'gastrointestinal',
                                'value'=>substr($model->gastrointestinal,0,1) == '1' ? 'Normal - '. substr($model->gastrointestinal,2) : 'Irregular - '. substr($model->gastrointestinal,2),
                            ],
                            [
                                'attribute'=>'endocrino',
                                'value'=>substr($model->endocrino,0,1) == '1' ? 'Normal - '. substr($model->endocrino,2) : 'Irregular - '. substr($model->endocrino,2),
                            ],
                            [
                                'attribute'=>'osteomuscular',
                                'value'=>substr($model->osteomuscular,0,1) == '1' ? 'Normal - '. substr($model->osteomuscular,2) : 'Irregular - '. substr($model->osteomuscular,2),
                            ],
                            [
                                'attribute'=>'nervioso',
                                'value'=>substr($model->nervioso,0,1) == '1' ? 'Normal - '. substr($model->nervioso,2) : 'Irregular - '. substr($model->nervioso,2),
                            ],
                            [
                                'attribute'=>'sensorial',
                                'value'=>substr($model->sensorial,0,1) == '1' ? 'Normal - '. substr($model->sensorial,2) : 'Irregular - '. substr($model->sensorial,2),
                            ],
                            [
                                'attribute'=>'psicosomatico',
                                'value'=>substr($model->psicosomatico,0,1) == '1' ? 'Normal - '. substr($model->psicosomatico,2) : 'Irregular - '. substr($model->psicosomatico,2),
                            ],
                            [
                                'attribute'=>'locomotor',
                                'value'=>substr($model->locomotor,0,1) == '1' ? 'Normal - '. substr($model->locomotor,2) : 'Irregular - '. substr($model->locomotor,2),
                            ],
                        ],
                    ]) ?>