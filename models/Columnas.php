<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "columnas".
 *
 * @property integer $id
 * @property string $campo
 * @property string $descripcion
 * @property string $alias
 * @property integer $total
 *
 * @property ColumnasInformes[] $columnasInformes
 */
class Columnas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'columnas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campo', 'descripcion', 'alias', 'total'], 'required'],
            [['total'], 'integer'],
            [['campo'], 'string', 'max' => 100],
            [['descripcion', 'alias'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campo' => 'Campo',
            'descripcion' => 'Descripcion',
            'alias' => 'Alias',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnasInformes()
    {
        return $this->hasMany(ColumnasInformes::className(), ['idcolumna' => 'id']);
    }
}
