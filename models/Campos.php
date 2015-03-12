<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "campos".
 *
 * @property integer $id
 * @property integer $idtipos_servicio
 * @property string $tipo_campo
 * @property string $nombre_campo
 * @property integer $titulos_idtitulos
 * @property integer $orden
 *
 * @property Titulos $titulosIdtitulos
 * @property TiposServicio $idtiposServicio
 * @property VlrsCamposProcedimientos[] $vlrsCamposProcedimientos
 */
class Campos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtipos_servicio', 'tipo_campo', 'nombre_campo', 'orden'], 'required'],
            [['idtipos_servicio', 'titulos_idtitulos', 'orden'], 'integer'],
            [['tipo_campo'], 'string', 'max' => 45],
            [['nombre_campo'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idtipos_servicio' => 'Tipos de servicio',
            'tipo_campo' => 'Tipo de campo',
            'nombre_campo' => 'Nombre de campo',
            'titulos_idtitulos' => 'Titulos',
            'orden' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitulosIdtitulos()
    {
        return $this->hasOne(Titulos::className(), ['id' => 'titulos_idtitulos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtiposServicio()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'idtipos_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVlrsCamposProcedimientos()
    {
        return $this->hasMany(VlrsCamposProcedimientos::className(), ['idcampos_tipos_servicio' => 'id']);
    }
}
