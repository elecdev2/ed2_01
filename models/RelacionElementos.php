<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relacion_elementos".
 *
 * @property string $parent
 * @property string $child
 * @property integer $id
 *
 * @property ElementosAutorizacion $child0
 * @property ElementosAutorizacion $parent0
 */
class RelacionElementos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relacion_elementos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(ElementosAutorizacion::className(), ['name' => 'child']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(ElementosAutorizacion::className(), ['name' => 'parent']);
    }
}
