<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formulacion".
 *
 * @property integer $id
 * @property string $formulacion
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class Formulacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formulacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['formulacion', 'id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['formulacion'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'formulacion' => 'Formulación',
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
