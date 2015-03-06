<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicos".
 *
 * @property integer $ips_idips
 * @property integer $idespecialidades
 * @property string $codigo
 * @property string $nombre
 * @property integer $id
 * @property integer $idclientes
 * @property string $ruta_firma
 *
 * @property Especialidades $idespecialidades0
 * @property Ips $ipsIdips
 * @property Procedimientos[] $procedimientos
 * @property Usuarios[] $usuarios
 */
class Medicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ips_idips', 'idespecialidades', 'codigo', 'nombre', 'idclientes'], 'required'],
            [['ips_idips', 'idespecialidades', 'idclientes'], 'integer'],
            [['codigo'], 'string', 'max' => 15],
            [['nombre', 'ruta_firma'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ips_idips' => 'Ips Idips',
            'idespecialidades' => 'Idespecialidades',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'id' => 'ID',
            'idclientes' => 'Idclientes',
            'ruta_firma' => 'Ruta Firma',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdespecialidades0()
    {
        return $this->hasOne(Especialidades::className(), ['id' => 'idespecialidades']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIpsIdips()
    {
        return $this->hasOne(Ips::className(), ['id' => 'ips_idips']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['idmedico' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['idmedicos' => 'id']);
    }
}
