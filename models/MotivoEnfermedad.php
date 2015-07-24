<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "motivo_enfermedad".
 *
 * @property integer $id
 * @property string $motivo
 * @property integer $id_historia
 * @property string $enfermedad
 *
 * @property HistoriaClinica $idHistoria
 */
class MotivoEnfermedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'motivo_enfermedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['motivo', 'enfermedad'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'motivo' => 'Motivo',
            'id_historia' => 'Id Historia',
            'enfermedad' => 'Enfermedad',
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
