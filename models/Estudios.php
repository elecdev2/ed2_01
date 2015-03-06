<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudios".
 *
 * @property string $cod_cups
 * @property string $descripcion
 *
 * @property EstudiosIps[] $estudiosIps
 * @property Procedimientos[] $procedimientos
 * @property Tarifas[] $tarifas
 */
class Estudios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_cups', 'descripcion'], 'required'],
            [['cod_cups'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_cups' => 'Cod Cups',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiosIps()
    {
        return $this->hasMany(EstudiosIps::className(), ['cod_cups' => 'cod_cups']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['cod_cups' => 'cod_cups']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
    {
        return $this->hasMany(Tarifas::className(), ['idestudios' => 'cod_cups']);
    }
}
