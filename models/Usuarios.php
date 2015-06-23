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
 * @property string $perfil 
 * @property string $sexo 
 * @property string $foto 
 * @property double $activo
 *
 * @property Procedimientos[] $procedimientos
 * @property Recibos[] $recibos
 * @property Clientes $idclientes0
 * @property Medicos $idmedicos0
 * @property UsuariosIps[] $usuariosIps
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;
    public $ips_medico;
    public $especialidad;
    public $codigo_medico;
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
            [['idmedicos', 'idclientes', 'ips_medico', 'especialidad'], 'integer'],
            [['password', 'nombre', 'idclientes', 'username', 'activo','perfil'], 'required'],
            [['activo'], 'number'],
            [['codigo_medico'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 255],
            [['nombre'], 'string', 'max' => 150],
            [['sexo'], 'string', 'max' => 1],
            [['foto'], 'string', 'max' => 120],
            [['username'], 'string', 'max' => 64],
            [['perfil'], 'string', 'max' => 45], 
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
            'perfil' => 'Perfil', 
            'activo' => 'Activo',
            'sexo'=>'Sexo',
            'foto'=>'Foto',
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

     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
         $usuario = Usuarios::find()->where(['id' => $id])->one();
        if ($usuario !== null) {
            return new static($usuario);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $usuario = Usuarios::find()->where(['accessToken' => $token])->one();
        if ($usuario['accessToken'] !== null) {
            return new static($usuario);
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuario = Usuarios::find()->where(['username' => $username])->one();
        if ($usuario !== null && $usuario['activo'] !== 2) {
            return new static($usuario);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
}
