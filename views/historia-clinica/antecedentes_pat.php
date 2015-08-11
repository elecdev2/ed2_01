<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'infecciosos',
                'value'=>substr($model->infecciosos,0,1) == '1' ? 'Si - ': 'No - '. substr($model->infecciosos,2),
            ],
            [
                'attribute'=>'enfermedades_mayores',
                'value'=>substr($model->enfermedades_mayores,0,1) == '1' ? 'Si - ': 'No - '. substr($model->enfermedades_mayores,2),
            ],
            [
                'attribute'=>'hospitalarios',
                'value'=>substr($model->hospitalarios,0,1) == '1' ? 'Si - ': 'No - '. substr($model->hospitalarios,2),
            ],
            [
                'attribute'=>'quirurgicos',
                'value'=>substr($model->quirurgicos,0,1) == '1' ? 'Si - ': 'No - '. substr($model->quirurgicos,2),
            ],
            [
                'attribute'=>'alergias',
                'value'=>substr($model->alergias,0,1) == '1' ? 'Si - ': 'No - '. substr($model->alergias,2),
            ],
            [
                'attribute'=>'traumaticos',
                'value'=>substr($model->traumaticos,0,1) == '1' ? 'Si - ': 'No - '. substr($model->traumaticos,2),
            ],
            [
                'attribute'=>'ets',
                'value'=>substr($model->ets,0,1) == '1' ? 'Si - ': 'No - '. substr($model->ets,2),
            ],
            [
                'attribute'=>'otros',
                'value'=>$model->otros,
            ],

        ],
    ]) ?>