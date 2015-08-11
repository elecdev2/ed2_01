<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recomendaciones".
 *
 * @property integer $id
 * @property string $recomendaciones
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class Recomendaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recomendaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recomendaciones', 'id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['recomendaciones'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recomendaciones' => 'Recomendaciones',
            'id_historia' => 'Id Historia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHistoria()
    {
        return $this->hasOne(HistoriaClinica::className(), ['id' => 'id_historia']);
    }
}
