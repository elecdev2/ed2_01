<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listas_sistema".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $descripcion
 * @property string $tipo
 */
class ListasSistema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'listas_sistema';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion', 'tipo'], 'required'],
            [['codigo', 'tipo'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'tipo' => 'Tipo',
        ];
    }
}
