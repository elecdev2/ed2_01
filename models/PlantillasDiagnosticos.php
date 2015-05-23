<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillas_diagnosticos".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property integer $id_medico
 *
 * @property Medicos $idMedico
 */
class PlantillasDiagnosticos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plantillas_diagnosticos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'id_medico'], 'required'],
            [['id_medico'], 'integer'],
            [['titulo'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripción',
            'id_medico' => 'Médico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMedico()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'id_medico']);
    }
}
