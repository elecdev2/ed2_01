<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>'alcohol',
                                'value'=>substr($model->alcohol,0,1) == '1' ? 'Si - '. substr($model->alcohol,2): 'No - '. substr($model->alcohol,2),
                            ],
                            [
                                'attribute'=>'tabaco',
                                'value'=>substr($model->tabaco,0,1) == '1' ? 'Si - '. substr($model->tabaco,2) : 'No - '. substr($model->tabaco,2),
                            ],
                            [
                                'attribute'=>'drogas',
                                'value'=>substr($model->drogas,0,1) == '1' ? 'Si - '. substr($model->drogas,2) : 'No - '. substr($model->drogas,2),
                            ],
                            [
                                'attribute'=>'actividad_fisica',
                                'value'=>substr($model->actividad_fisica,0,1) == '1' ? 'Si - '. substr($model->actividad_fisica,2) : 'No - '. substr($model->actividad_fisica,2),
                            ],
                            [
                                'attribute'=>'otros',
                                'value'=>$model->otros,
                            ],
                        ],
                    ]) ?>