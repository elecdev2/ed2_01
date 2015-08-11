<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "examen_fisico".
 *
 * @property integer $id
 * @property integer $peso
 * @property integer $estatura
 * @property string $presion_arterial
 * @property integer $frec_respiratoria
 * @property integer $pulso
 * @property integer $temperatura
 * @property string $complexion
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class ExamenFisico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examen_fisico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peso', 'estatura', 'frec_respiratoria', 'pulso', 'temperatura', 'id_historia'], 'integer'],
            [['id_historia'], 'required'],
            [['presion_arterial', 'complexion'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peso' => 'Peso (Kg)',
            'estatura' => 'Estatura (cm)',
            'presion_arterial' => 'Presion Arterial (mm de Hg)',
            'frec_respiratoria' => 'Frec Respiratoria',
            'pulso' => 'Pulso',
            'temperatura' => 'Temperatura (°C)',
            'complexion' => 'Complexion',
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
