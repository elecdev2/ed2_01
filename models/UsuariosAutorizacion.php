<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_autorizacion".
 *
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 * @property integer $id
 *
 * @property ElementosAutorizacion $itemname0
 */
class UsuariosAutorizacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios_autorizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemname', 'userid'], 'required'],
            [['bizrule', 'data'], 'string'],
            [['itemname', 'userid'], 'string', 'max' => 64],
            [['itemname', 'userid'], 'unique', 'targetAttribute' => ['itemname', 'userid'], 'message' => 'The combination of Itemname and Userid has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemname' => 'Itemname',
            'userid' => 'Userid',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemname0()
    {
        return $this->hasOne(ElementosAutorizacion::className(), ['name' => 'itemname']);
    }
}
