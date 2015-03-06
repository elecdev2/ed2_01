<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_servicio".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $idips
 * @property integer $consecutivo
 * @property string $serie
 *
 * @property Campos[] $campos
 * @property EstudiosIps[] $estudiosIps
 * @property Procedimientos[] $procedimientos
 */
class TiposServicio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_servicio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['idips', 'consecutivo'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['serie'], 'string', 'max' => 1]
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
            'idips' => 'Idips',
            'consecutivo' => 'Consecutivo',
            'serie' => 'Serie',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampos()
    {
        return $this->hasMany(Campos::className(), ['idtipos_servicio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiosIps()
    {
        return $this->hasMany(EstudiosIps::className(), ['idtipo_servicio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimientos()
    {
        return $this->hasMany(Procedimientos::className(), ['idtipo_servicio' => 'id']);
    }
}
