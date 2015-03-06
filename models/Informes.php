<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informes".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property ColumnasInformes[] $columnasInformes
 * @property Eps[] $eps
 */
class Informes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'informes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnasInformes()
    {
        return $this->hasMany(ColumnasInformes::className(), ['idinforme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEps()
    {
        return $this->hasMany(Eps::className(), ['idinformes' => 'id']);
    }
}
