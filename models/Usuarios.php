<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id
 * @property integer $idmedicos
 * @property string $password
 * @property string $nombre
 * @property integer $idclientes
 * @property string $username
 * @property double $activo
 *
 * @property Procedimientos[] $procedimientos
 * @property Recibos[] $recibos
 * @property Clientes $idclientes0
 * @property Medicos $idmedicos0
 * @property UsuariosIps[] $usuariosIps
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idmedicos', 'idclientes'], 'integer'],
            [['password', 'nombre', 'idclientes', 'username', 'activo'], 'required'],
            [['activo'], 'number'],
            [['password'], 'string', 'max' => 128],
            [['nombre'], 'string', 'max' => 150],
            [['username'], 'string', 'max' => 64],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idmedicos' => 'Idmedicos',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'idclientes' => 'Idclientes',
            'username' => 'Username',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['usuario_transcribe' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibos()
    {
        return $this->hasMany(Recibos::className(), ['idusuario' => 'id']);
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
    public function getIdmedicos0()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'idmedicos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosIps()
    {
        return $this->hasMany(UsuariosIps::className(), ['idusuario' => 'id']);
    }
}
