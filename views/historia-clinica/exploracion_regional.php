<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>'cabeza',
                                'value'=>substr($model->cabeza,0,1) == '1' ? 'Normal - '. substr($model->cabeza,2): 'Irregular - '. substr($model->cabeza,2),
                            ],
                            [
                                'attribute'=>'cuello',
                                'value'=>substr($model->cuello,0,1) == '1' ? 'Normal - '. substr($model->cuello,2) : 'Irregular - '. substr($model->cuello,2),
                            ],
                            [
                                'attribute'=>'torax',
                                'value'=>substr($model->torax,0,1) == '1' ? 'Normal - '. substr($model->torax,2) : 'Irregular - '. substr($model->torax,2),
                            ],
                            [
                                'attribute'=>'abdomen',
                                'value'=>substr($model->abdomen,0,1) == '1' ? 'Normal - '. substr($model->abdomen,2) : 'Irregular - '. substr($model->abdomen,2),
                            ],
                            [
                                'attribute'=>'miembros',
                                'value'=>substr($model->miembros,0,1) == '1' ? 'Normal - '. substr($model->miembros,2) : 'Irregular - '. substr($model->miembros,2),
                            ],
                            [
                                'attribute'=>'genitales',
                                'value'=>substr($model->genitales,0,1) == '1' ? 'Normal - '. substr($model->genitales,2) : 'Irregular - '. substr($model->genitales,2),
                            ],
                        ],
                    ]) ?>