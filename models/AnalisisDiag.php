<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "analisis_diag".
 *
 * @property integer $id
 * @property string $analisis
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 * @property AnalisisImpresiondiagnostica[] $analisisImpresiondiagnosticas
 */
class AnalisisDiag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'analisis_diag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['analisis'], 'string', 'max' => 1002]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'analisis' => 'Analisis',
            'id_historia' => 'Id Historia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHistoria()
    {
        return $this->hasOne(HistoriaClinica::className(), ['id' => 'id_historia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisisImpresiondiagnosticas()
    {
        return $this->hasMany(AnalisisImpresiondiagnostica::className(), ['id_analisis' => 'id']);
    }
}
