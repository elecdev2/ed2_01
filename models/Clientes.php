<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $activo
 * @property string $tema
 * @property string $tipo_consecutivo
 *
 * @property Ips[] $ips
 * @property Pacientes[] $pacientes
 * @property Usuarios[] $usuarios
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'activo'], 'required'],
            [['activo'], 'integer', 'message' => 'Por favor seleccione una opción'],
            [['nombre'], 'string', 'max' => 100],
            [['tema'], 'string', 'max' => 45],
            [['tipo_consecutivo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'activo' => 'Activo',
            'tema' => 'Tema',
            'tipo_consecutivo' => 'Tipo Consecutivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIps()
    {
        return $this->hasMany(Ips::className(), ['idclientes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Pacientes::className(), ['idclientes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['idclientes' => 'id']);
    }
}
