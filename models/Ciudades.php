<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudades".
 *
 * @property string $nombre
 * @property string $codigo
 * @property integer $id
 * @property string $codigo_departamento
 *
 * @property Departamentos $codigoDepartamento
 */
class Ciudades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'codigo'], 'required'],
            [['nombre'], 'string', 'max' => 150],
            [['codigo'], 'string', 'max' => 15],
            [['codigo_departamento'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'id' => 'ID',
            'codigo_departamento' => 'Codigo Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'codigo_departamento']);
    }
}
