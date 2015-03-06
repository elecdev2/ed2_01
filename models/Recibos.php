<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recibos".
 *
 * @property integer $id
 * @property integer $idprocedimiento
 * @property integer $num_recibo
 * @property double $valor_saldo
 * @property double $valor_abono
 * @property integer $idusuario
 * @property string $fecha
 *
 * @property Procedimientos $idprocedimiento0
 * @property Usuarios $idusuario0
 */
class Recibos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recibos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idprocedimiento', 'num_recibo', 'valor_saldo', 'valor_abono', 'idusuario', 'fecha'], 'required'],
            [['idprocedimiento', 'num_recibo', 'idusuario'], 'integer'],
            [['valor_saldo', 'valor_abono'], 'number'],
            [['fecha'], 'safe'],
            [['idprocedimiento', 'valor_saldo', 'valor_abono'], 'unique', 'targetAttribute' => ['idprocedimiento', 'valor_saldo', 'valor_abono'], 'message' => 'The combination of Idprocedimiento, Valor Saldo and Valor Abono has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idprocedimiento' => 'Idprocedimiento',
            'num_recibo' => 'Num Recibo',
            'valor_saldo' => 'Valor Saldo',
            'valor_abono' => 'Valor Abono',
            'idusuario' => 'Idusuario',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprocedimiento0()
    {
        return $this->hasOne(Procedimientos::className(), ['id' => 'idprocedimiento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdusuario0()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'idusuario']);
    }
}
