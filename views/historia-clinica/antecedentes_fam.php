<?php 
use yii\widgets\DetailView;
 ?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'diabetes',
                'value'=>substr($model->diabetes,0,1) == '1' ? 'Si - '. substr($model->diabetes,2): 'No - '. substr($model->diabetes,2),
            ],
            [
                'attribute'=>'hipertension',
                'value'=>substr($model->hipertension,0,1) == '1' ? 'Si - '. substr($model->hipertension,2) : 'No - '. substr($model->hipertension,2),
            ],
            [
                'attribute'=>'cardiopatia',
                'value'=>substr($model->cardiopatia,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->cardiopatia,2),
            ],
            [
                'attribute'=>'hepatopatia',
                'value'=>substr($model->hepatopatia,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->hepatopatia,2),
            ],
            [
                'attribute'=>'nefropatia',
                'value'=>substr($model->nefropatia,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->nefropatia,2),
            ],
            [
                'attribute'=>'enf_mentales',
                'value'=>substr($model->enf_mentales,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->enf_mentales,2),
            ],
            [
                'attribute'=>'asma',
                'value'=>substr($model->asma,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->asma,2),
            ],
            [
                'attribute'=>'cancer',
                'value'=>substr($model->cancer,0,1) == '1' ? 'Si - '. substr($model->diabetes,2) : 'No - '. substr($model->cancer,2),
            ],
            [
                'attribute'=>'enf_alergicas',
                'value'=>substr($model->enf_alergicas,0,1) == '1' ? 'Si - ': 'No - '. substr($model->enf_alergicas,2),
            ],
            [
                'attribute'=>'otros',
                'value'=>$model->otros,
            ],
        ],
    ]) ?>