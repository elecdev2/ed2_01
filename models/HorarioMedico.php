<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horario_medico".
 *
 * @property integer $id_horario
 * @property integer $medicos_id
 * @property integer $dia
 * @property string $horas
 *
 * @property Medicos $medicos
 */
class HorarioMedico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'horario_medico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medicos_id', 'dia'], 'required'],
            [['medicos_id', 'dia'], 'integer'],
            [['horas'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'medicos_id' => 'Medicos ID',
            'dia' => 'Dia',
            'horas' => 'Horas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'medicos_id']);
    }
}
