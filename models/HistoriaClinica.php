<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historia_clinica".
 *
 * @property integer $id
 * @property integer $id_paciente
 * @property integer $id_tipos
 * @property string $fecha
 * @property string $hora
 * @property integer $id_medico
 *
 * @property Medicos $idMedico
 * @property Pacientes $idPaciente
 * @property TiposServicio $idTipos
 */
class HistoriaClinica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historia_clinica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_tipos', 'id_medico'], 'required'],
            [['id_paciente', 'id_tipos', 'id_medico'], 'integer'],
            [['fecha', 'hora'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_tipos' => 'Id Tipos',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'id_medico' => 'Id Medico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMedico()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'id_medico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPaciente()
    {
        return $this->hasOne(Pacientes::className(), ['id' => 'id_paciente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipos()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'id_tipos']);
    }
}
