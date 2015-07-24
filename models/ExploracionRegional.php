<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exploracion_regional".
 *
 * @property integer $id
 * @property string $cabeza
 * @property string $cuello
 * @property string $torax
 * @property string $abdomen
 * @property string $miembros
 * @property string $genitales
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class ExploracionRegional extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exploracion_regional';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['cabeza', 'cuello', 'torax', 'abdomen', 'miembros', 'genitales'], 'string', 'max' => 302]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cabeza' => 'Cabeza',
            'cuello' => 'Cuello',
            'torax' => 'Torax',
            'abdomen' => 'Abdomen',
            'miembros' => 'Miembros',
            'genitales' => 'Genitales',
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
}
