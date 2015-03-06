<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidades".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 *
 * @property Medicos[] $medicos
 */
class Especialidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'especialidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre'], 'required'],
            [['codigo'], 'string', 'max' => 15],
            [['nombre'], 'string', 'max' => 150]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medicos::className(), ['idespecialidades' => 'id']);
    }
}
