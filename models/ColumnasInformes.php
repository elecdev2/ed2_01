<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "columnas_informes".
 *
 * @property integer $id
 * @property integer $idinforme
 * @property integer $idcolumna
 * @property integer $orden
 *
 * @property Columnas $idcolumna0
 * @property Informes $idinforme0
 */
class ColumnasInformes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'columnas_informes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idinforme', 'idcolumna'], 'required'],
            [['idinforme', 'idcolumna', 'orden'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idinforme' => 'Idinforme',
            'idcolumna' => 'Idcolumna',
            'orden' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcolumna0()
    {
        return $this->hasOne(Columnas::className(), ['id' => 'idcolumna']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdinforme0()
    {
        return $this->hasOne(Informes::className(), ['id' => 'idinforme']);
    }
}
