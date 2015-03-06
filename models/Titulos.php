<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "titulos".
 *
 * @property integer $id
 * @property string $descripcion
 *
 * @property Campos[] $campos
 */
class Titulos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'titulos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampos()
    {
        return $this->hasMany(Campos::className(), ['titulos_idtitulos' => 'id']);
    }
}
