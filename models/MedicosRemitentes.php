<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicos_remitentes".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $telefono
 * @property string $email
 * @property integer $especialidades_id
 *
 * @property Especialidades $especialidades
 * @property MedicosRemitentesIps[] $medicosRemitentesIps 
 * @property Procedimientos[] $procedimientos
 */
class MedicosRemitentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicos_remitentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['especialidades_id','nombre'], 'required'],
            [['especialidades_id'], 'integer'],
            [['email'], 'email'],
            [['codigo'], 'string', 'max' => 15],
            [['nombre'], 'string', 'max' => 150],
            [['telefono', 'email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'email' => 'Email',
            'especialidades_id' => 'Especialidades ID',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getMedicosRemitentesIps() 
   { 
       return $this->hasMany(MedicosRemitentesIps::className(), ['medicos_remitentes_id' => 'id']); 
   } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidades()
    {
        return $this->hasOne(Especialidades::className(), ['id' => 'especialidades_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['medico' => 'id']);
    }
}
