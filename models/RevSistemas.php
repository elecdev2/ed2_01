<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rev_sistemas".
 *
 * @property integer $id
 * @property string $cardiorespiratorio
 * @property string $gastrointestinal
 * @property string $endocrino
 * @property string $osteomuscular
 * @property string $nervioso
 * @property string $sensorial
 * @property string $psicosomatico
 * @property string $locomotor
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class RevSistemas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rev_sistemas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['cardiorespiratorio', 'gastrointestinal', 'endocrino', 'osteomuscular', 'nervioso', 'sensorial', 'psicosomatico', 'locomotor'], 'string', 'max' => 302]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cardiorespiratorio' => 'Cardiorespiratorio',
            'gastrointestinal' => 'Gastrointestinal',
            'endocrino' => 'Endocrino',
            'osteomuscular' => 'Osteomuscular',
            'nervioso' => 'Nervioso',
            'sensorial' => 'Sensorial',
            'psicosomatico' => 'Psicosomatico',
            'locomotor' => 'Locomotor',
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
