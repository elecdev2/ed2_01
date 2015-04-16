<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eps_tipos".
 *
 * @property integer $id
 * @property integer $tipos_servicio_id
 * @property integer $eps_id
 *
 * @property Eps $eps
 * @property TiposServicio $tiposServicio
 */
class EpsTipos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eps_tipos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipos_servicio_id', 'eps_id'], 'required'],
            [['tipos_servicio_id', 'eps_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipos_servicio_id' => 'Tipos Servicio ID',
            'eps_id' => 'Eps ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEps()
    {
        return $this->hasOne(Eps::className(), ['id' => 'eps_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposServicio()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'tipos_servicio_id']);
    }
}
