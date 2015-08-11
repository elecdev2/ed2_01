<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivos_historial".
 *
 * @property integer $id
 * @property string $archivo
 * @property integer $id_historia
 *
 * @property HistoriaClinica $idHistoria
 */
class ArchivosHistorial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'archivos_historial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['archivo', 'id_historia'], 'required'],
            [['id_historia'], 'integer'],
            [['archivo'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'archivo' => 'Archivo',
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
