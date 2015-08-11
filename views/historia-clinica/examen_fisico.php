<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>'peso',
                                'value'=>$model->peso.' Kg',
                            ],
                            [
                                'attribute'=>'estatura',
                                'value'=>$model->estatura.' cm',
                            ],
                            [
                                'attribute'=>'presion_arterial',
                                'value'=>$model->presion_arterial.' mm de Hg',
                            ],
                            [
                                'attribute'=>'frec_respiratoria',
                                'value'=>$model->frec_respiratoria,
                            ],
                            [
                                'attribute'=>'pulso',
                                'value'=>$model->pulso,
                            ],
                            [
                                'attribute'=>'temperatura',
                                'value'=>$model->temperatura. ' °C',
                            ],
                            [
                                'attribute'=>'complexion',
                                'value'=>$model->complexion,
                            ],
                        ],
                    ]) ?>