<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "habitos".
 *
 * @property integer $id
 * @property string $alcohol
 * @property string $tabaco
 * @property string $drogas
 * @property string $actividad_fisica
 * @property string $otros
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class Habitos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'habitos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['alcohol', 'tabaco', 'drogas', 'actividad_fisica'], 'string', 'max' => 302],
            [['otros'], 'string', 'max' => 1002]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alcohol' => 'Alcohol',
            'tabaco' => 'Tabaco',
            'drogas' => 'Drogas',
            'actividad_fisica' => 'Actividad Fisica',
            'otros' => 'Otros',
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
