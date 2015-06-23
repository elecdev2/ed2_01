<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "citas_medicas".
 *
 * @property integer $id_citas
 * @property integer $pacientes_id
 * @property integer $medicos_id
 * @property string $fecha
 * @property string $hora
 * @property string $observaciones
 *
 * @property Medicos $medicos
 * @property Pacientes $pacientes
 */
class CitasMedicas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citas_medicas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pacientes_id', 'medicos_id', 'fecha', 'hora'], 'required'],
            [['pacientes_id', 'medicos_id'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['observaciones'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_citas' => 'Citas',
            'pacientes_id' => 'Paciente',
            'medicos_id' => 'Médico',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'medicos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasOne(Pacientes::className(), ['id' => 'pacientes_id']);
    }
}
