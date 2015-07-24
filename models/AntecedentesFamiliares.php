<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "antecedentes_familiares".
 *
 * @property integer $id
 * @property integer $id_historia
 * @property string $diabetes
 * @property string $hipertension
 * @property string $cardiopatia
 * @property string $hepatopatia
 * @property string $nefropatia
 * @property string $enf_mentales
 * @property string $asma
 * @property string $cancer
 * @property string $enf_alergicas
 * @property string $otros
 *
 * @property HistoriaClinica $idHistoria
 */
class AntecedentesFamiliares extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'antecedentes_familiares';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['diabetes', 'hipertension', 'cardiopatia', 'hepatopatia', 'nefropatia', 'enf_mentales', 'asma', 'cancer', 'enf_alergicas'], 'string', 'max' => 302],
            [['otros'], 'string', 'max' => 502]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_historia' => 'Id Historia',
            'diabetes' => 'Diabetes',
            'hipertension' => 'Hipertension',
            'cardiopatia' => 'Cardiopatia',
            'hepatopatia' => 'Hepatopatia',
            'nefropatia' => 'Nefropatia',
            'enf_mentales' => 'Enf Mentales',
            'asma' => 'Asma',
            'cancer' => 'Cancer',
            'enf_alergicas' => 'Enf Alergicas',
            'otros' => 'Otros',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHistoria()
    {
        return $this->hasOne(HistoriaClinica::className(), ['id' => 'id_historia']);
    }
}
