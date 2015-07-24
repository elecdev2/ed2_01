<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "antecedentes_patologicos".
 *
 * @property integer $id
 * @property string $infecciosos
 * @property string $enfermedades_mayores
 * @property string $hospitalarios
 * @property string $quirurgicos
 * @property string $alergias
 * @property string $traumaticos
 * @property string $ets
 * @property string $otros
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class AntecedentesPatologicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'antecedentes_patologicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['infecciosos', 'enfermedades_mayores', 'hospitalarios', 'quirurgicos', 'alergias', 'traumaticos', 'ets'], 'string', 'max' => 302],
            [['otros'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'infecciosos' => 'Infecciosos',
            'enfermedades_mayores' => 'Enfermedades Mayores',
            'hospitalarios' => 'Hospitalarios',
            'quirurgicos' => 'Quirurgicos',
            'alergias' => 'Alergias',
            'traumaticos' => 'Traumaticos',
            'ets' => 'ETS',
            'otros' => 'Otros',
            'id_historia' => 'N° Historia',
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
