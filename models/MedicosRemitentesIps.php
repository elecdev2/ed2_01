<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicos_remitentes_ips".
 *
 * @property integer $id
 * @property integer $medicos_remitentes_id
 * @property integer $ips_id
 *
 * @property Ips $ips
 * @property MedicosRemitentes $medicosRemitentes
 */
class MedicosRemitentesIps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicos_remitentes_ips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medicos_remitentes_id', 'ips_id'], 'required'],
            [['medicos_remitentes_id', 'ips_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medicos_remitentes_id' => 'Medicos Remitentes ID',
            'ips_id' => 'Ips ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIps()
    {
        return $this->hasOne(Ips::className(), ['id' => 'ips_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicosRemitentes()
    {
        return $this->hasOne(MedicosRemitentes::className(), ['id' => 'medicos_remitentes_id']);
    }
}
