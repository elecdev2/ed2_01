<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudios_ips".
 *
 * @property integer $id
 * @property string $cod_cups
 * @property integer $idtipo_servicio
 *
 * @property Estudios $codCups
 * @property TiposServicio $idtipoServicio
 */
class EstudiosIps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudios_ips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_cups', 'idtipo_servicio'], 'required'],
            [['idtipo_servicio'], 'integer'],
            [['cod_cups'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cod_cups' => 'Cod Cups',
            'idtipo_servicio' => 'Idtipo Servicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodCups()
    {
        return $this->hasOne(Estudios::className(), ['cod_cups' => 'cod_cups']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtipoServicio()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'idtipo_servicio']);
    }
}
