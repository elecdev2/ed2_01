<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "elementos_autorizacion".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 * @property integer $jerarquia
 *
 * @property RelacionElementos[] $relacionElementos
 * @property UsuariosAutorizacion[] $usuariosAutorizacions
 */
class ElementosAutorizacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elementos_autorizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'jerarquia'], 'integer'],
            [['description', 'bizrule', 'data'], 'string'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
            'jerarquia' => 'Jerarquia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelacionElementos()
    {
        return $this->hasMany(RelacionElementos::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosAutorizacions()
    {
        return $this->hasMany(UsuariosAutorizacion::className(), ['itemname' => 'name']);
    }
}
