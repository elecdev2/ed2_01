<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarifas".
 *
 * @property integer $id
 * @property integer $eps_id
 * @property string $idestudios
 * @property double $valor_procedimiento
 * @property double $descuento
 *
 * @property Eps $eps
 * @property Estudios $idestudios0
 */
class Tarifas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarifas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eps_id', 'idestudios', 'valor_procedimiento', 'descuento'], 'required'],
            [['eps_id'], 'integer'],
            [['valor_procedimiento', 'descuento'], 'number'],
            [['idestudios'], 'string', 'max' => 20],
            [['eps_id', 'idestudios'], 'unique', 'targetAttribute' => ['eps_id', 'idestudios'], 'message' => 'The combination of Eps ID and Idestudios has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eps_id' => 'Eps ID',
            'idestudios' => 'Idestudios',
            'valor_procedimiento' => 'Valor Procedimiento',
            'descuento' => 'Descuento',
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
    public function getIdestudios0()
    {
        return $this->hasOne(Estudios::className(), ['cod_cups' => 'idestudios']);
    }
}
