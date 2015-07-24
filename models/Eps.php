<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eps".
 *
 * @property integer $id
 * @property integer $idips
 * @property string $codigo
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $nit
 * @property integer $generar_rip
 * @property integer $idinformes
 * @property integer $activo
 *
 * @property Informes $idinformes0
 * @property Ips $idips0
 * @property EpsTipos[] $epsTipos 
 * @property Pacientes[] $pacientes
 * @property Procedimientos[] $procedimientos
 * @property Tarifas[] $tarifas
 */
class Eps extends \yii\db\ActiveRecord
{
    public $tipos_est;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idips', 'codigo', 'nombre', 'direccion', 'telefono', 'nit', 'generar_rip', 'idinformes', 'activo'], 'required'],
            [['tipos_est'], 'safe'],
            [['idips', 'generar_rip', 'idinformes','tipos_est'], 'integer'],
            [['codigo', 'telefono'], 'string', 'max' => 15],
            [['nombre'], 'string', 'max' => 150],
            [['direccion'], 'string', 'max' => 100],
            [['nit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idips' => 'IPS',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'direccion' => 'Dirección',
            'telefono' => 'Teléfono',
            'nit' => 'Nit',
            'generar_rip' => 'Generar Rip',
            'idinformes' => 'Informe',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdinformes0()
    {
        return $this->hasOne(Informes::className(), ['id' => 'idinformes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdips0()
    {
        return $this->hasOne(Ips::className(), ['id' => 'idips']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getEpsTipos() 
   { 
       return $this->hasMany(EpsTipos::className(), ['eps_id' => 'id']); 
   } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Pacientes::className(), ['ideps' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['eps_ideps' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
    {
        return $this->hasMany(Tarifas::className(), ['eps_id' => 'id']);
    }
}
