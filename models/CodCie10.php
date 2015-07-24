<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cod_cie10".
 *
 * @property string $codigo
 * @property string $descripcion
 *
 * @property AnalisisImpresiondiagnostica[] $analisisImpresiondiagnosticas
 */
class CodCie10 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cod_cie10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisisImpresiondiagnosticas()
    {
        return $this->hasMany(AnalisisImpresiondiagnostica::className(), ['id_cod' => 'codigo']);
    }
}
