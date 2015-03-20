<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pacientes".
 *
 * @property integer $id
 * @property string $tipo_identificacion
 * @property string $identificacion
 * @property string $apellido1
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido2
 * @property string $direccion
 * @property string $telefono
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $tipo_usuario
 * @property string $tipo_residencia
 * @property integer $idclientes
 * @property integer $activo
 * @property integer $idciudad
 * @property integer $ideps
 * @property string $email
 * @property integer $envia_email
 * @property string $codeps
 *
 * @property Clientes $idclientes0
 * @property Eps $ideps0
 * @property Procedimientos[] $procedimientos
 */
class Pacientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pacientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_identificacion', 'identificacion', 'apellido1', 'nombre1', 'direccion', 'sexo', 'fecha_nacimiento', 'idclientes'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['idclientes', 'idciudad', 'ideps'], 'integer'],
            [['tipo_identificacion'], 'string', 'max' => 3],
            [['identificacion', 'telefono', 'codeps'], 'string', 'max' => 15],
            [['apellido1', 'nombre1', 'nombre2', 'apellido2'], 'string', 'max' => 30],
            [['direccion', 'email'], 'string', 'max' => 100],
            [['tipo_usuario', 'tipo_residencia'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_identificacion' => 'Tipo de ID',
            'identificacion' => 'Número de ID',
            'apellido1' => 'Primer Apellido',
            'nombre1' => 'Primer Nombre',
            'nombre2' => 'Segundo Nombre',
            'apellido2' => 'Segundo Apellido',
            'direccion' => 'Dirección',
            'telefono' => 'Teléfono',
            'sexo' => 'Sexo',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'tipo_usuario' => 'Tipo de Usuario',
            'tipo_residencia' => 'Tipo Residencia',
            'idclientes' => 'Idclientes',
            'activo' => 'Activo',
            'idciudad' => 'Idciudad',
            'ideps' => 'Ideps',
            'email' => 'Email',
            'envia_email' => 'Enviar Email',
            'codeps' => 'Codeps',
        ];
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
    public function getIdeps0()
    {
        return $this->hasOne(Eps::className(), ['id' => 'ideps']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['idpacientes' => 'id']);
    }
}
