<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_ips".
 *
 * @property integer $idusuario
 * @property integer $idips
 * @property integer $id
 *
 * @property Ips $idips0
 * @property Usuarios $idusuario0
 */
class UsuariosIps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios_ips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idusuario', 'idips'], 'required'],
            [['idusuario', 'idips'], 'integer'],
            [['idusuario', 'idips'], 'unique', 'targetAttribute' => ['idusuario', 'idips'], 'message' => 'The combination of Idusuario and Idips has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idusuario' => 'Idusuario',
            'idips' => 'Idips',
            'id' => 'ID',
        ];
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
    public function getIdusuario0()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'idusuario']);
    }
}
