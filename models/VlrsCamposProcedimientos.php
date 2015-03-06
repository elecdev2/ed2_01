<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vlrs_campos_procedimientos".
 *
 * @property integer $id
 * @property string $valor
 * @property integer $id_procedimiento
 * @property integer $idcampos_tipos_servicio
 *
 * @property Campos $idcamposTiposServicio
 * @property Procedimientos $idProcedimiento
 */
class VlrsCamposProcedimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vlrs_campos_procedimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor', 'id_procedimiento', 'idcampos_tipos_servicio'], 'required'],
            [['id_procedimiento', 'idcampos_tipos_servicio'], 'integer'],
            [['valor'], 'string', 'max' => 1000],
            [['idcampos_tipos_servicio', 'id_procedimiento'], 'unique', 'targetAttribute' => ['idcampos_tipos_servicio', 'id_procedimiento'], 'message' => 'The combination of Id Procedimiento and Idcampos Tipos Servicio has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor' => 'Valor',
            'id_procedimiento' => 'Id Procedimiento',
            'idcampos_tipos_servicio' => 'Idcampos Tipos Servicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcamposTiposServicio()
    {
        return $this->hasOne(Campos::className(), ['id' => 'idcampos_tipos_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProcedimiento()
    {
        return $this->hasOne(Procedimientos::className(), ['id' => 'id_procedimiento']);
    }
}
