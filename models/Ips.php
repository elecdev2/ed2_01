<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ips".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $direccion
 * @property string $tipo_identificacion
 * @property string $nit
 * @property string $telefono
 * @property integer $idclientes
 * @property integer $activo
 * @property integer $consecutivo_fact
 * @property string $representante_legal
 * @property integer $consecutivo_recibo
 * @property string $descripcion
 * @property string $mensaje_email
 *
 * @property Eps[] $eps
 * @property Clientes $idclientes0
 * @property Medicos[] $medicos
 * @property UsuariosIps[] $usuariosIps
 */
class Ips extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre', 'direccion', 'tipo_identificacion', 'nit', 'telefono', 'idclientes', 'activo', 'consecutivo_fact', 'representante_legal', 'consecutivo_recibo', 'mensaje_email'], 'required'],
            [['idclientes', 'activo', 'consecutivo_fact', 'consecutivo_recibo'], 'integer'],
            [['codigo', 'nit'], 'string', 'max' => 15],
            [['nombre'], 'string', 'max' => 150],
            [['direccion', 'representante_legal', 'descripcion'], 'string', 'max' => 100],
            [['tipo_identificacion'], 'string', 'max' => 3],
            [['telefono'], 'string', 'max' => 30],
            [['mensaje_email'], 'string', 'max' => 1000]
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
            'direccion' => 'Direccion',
            'tipo_identificacion' => 'Tipo Identificacion',
            'nit' => 'Nit',
            'telefono' => 'Telefono',
            'idclientes' => 'Idclientes',
            'activo' => 'Activo',
            'consecutivo_fact' => 'Consecutivo Fact',
            'representante_legal' => 'Representante Legal',
            'consecutivo_recibo' => 'Consecutivo Recibo',
            'descripcion' => 'Descripcion',
            'mensaje_email' => 'Mensaje Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEps()
    {
        return $this->hasMany(Eps::className(), ['idips' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdclientes0()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'idclientes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medicos::className(), ['ips_idips' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosIps()
    {
        return $this->hasMany(UsuariosIps::className(), ['idips' => 'id']);
    }
}