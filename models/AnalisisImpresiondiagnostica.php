<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "analisis_impresiondiagnostica".
 *
 * @property integer $id
 * @property integer $id_analisis
 * @property string $id_cod
 *
 * @property AnalisisDiag $idAnalisis
 * @property CodCie10 $idCod
 */
class AnalisisImpresiondiagnostica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'analisis_impresiondiagnostica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_analisis'], 'integer'],
            [['id_cod'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_analisis' => 'Id Analisis',
            'id_cod' => 'Id Cod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAnalisis()
    {
        return $this->hasOne(AnalisisDiag::className(), ['id' => 'id_analisis']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCod()
    {
        return $this->hasOne(CodCie10::className(), ['codigo' => 'id_cod']);
    }
}
