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
 * @property integer $id_procedimiento 
 *
 * @property AnalisisDiag[] $analisisDiags 
 * @property AntecedentesFamiliares[] $antecedentesFamiliares 
 * @property AntecedentesPatologicos[] $antecedentesPatologicos 
 * @property ArchivosHistorial[] $archivosHistorials 
 * @property ExamenFisico[] $examenFisicos 
 * @property ExploracionRegional[] $exploracionRegionals 
 * @property Formulacion[] $formulacions 
 * @property Habitos[] $habitos 
 * @property Medicos $idMedico
 * @property Pacientes $idPaciente
 * @property TiposServicio $idTipos
 * @property MotivoEnfermedad[] $motivoEnfermedads 
 * @property Recomendaciones[] $recomendaciones 
 * @property RevSistemas[] $revSistemas 
 */
class HistoriaClinica extends \yii\db\ActiveRecord
{
    public $diag;
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
            [['id_paciente', 'id_tipos', 'id_medico', 'id_procedimiento'], 'required'],
            [['id_paciente', 'id_tipos', 'id_medico'], 'integer'],
            [['fecha', 'hora', 'diag'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Paciente',
            'id_tipos' => 'Tipo servicio',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'id_medico' => 'Médico',
            'id_procedimiento' => 'Procedimiento', 
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
    public function getIdProcedimiento() 
    { 
       return $this->hasOne(Procedimientos::className(), ['id' => 'id_procedimiento']); 
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipos()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'id_tipos']);
    }
}
