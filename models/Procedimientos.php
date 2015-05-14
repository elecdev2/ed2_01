<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedimientos".
 *
 * @property integer $id
 * @property integer $idpacientes
 * @property string $fecha_atencion
 * @property string $autorizacion
 * @property string $numero_muestra
 * @property double $valor_procedimiento
 * @property integer $eps_ideps
 * @property string $cod_cups
 * @property integer $cantidad_muestras
 * @property double $valor_copago
 * @property double $valor_saldo
 * @property double $valor_abono
 * @property integer $medico
 * @property string $observaciones
 * @property string $forma_pago
 * @property string $numero_cheque
 * @property string $estado
 * @property string $fecha_informe
 * @property string $numero_factura
 * @property string $fecha_salida
 * @property string $fecha_entrega
 * @property string $periodo_facturacion
 * @property integer $idtipo_servicio
 * @property integer $idmedico
 * @property integer $usuario_recibe
 * @property integer $usuario_transcribe
 * @property double $descuento
 * @property string $fecha_inicio
 * @property string $fecha_fin
 *
 * @property Eps $epsIdeps
 * @property Estudios $codCups
 * @property Pacientes $idpacientes0
 * @property MedicosRemitentes $medico0 
 * @property Usuarios $usuarioRecibe
 * @property Usuarios $usuarioTranscribe
 * @property Medicos $idmedico0
 * @property TiposServicio $idtipoServicio
 * @property Recibos[] $recibos
 * @property VlrsCamposProcedimientos[] $vlrsCamposProcedimientos
 */
class Procedimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'procedimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpacientes', 'fecha_atencion', 'numero_muestra', 'eps_ideps', 'cod_cups', 'cantidad_muestras', 'idtipo_servicio'], 'required'],
            [['idpacientes', 'eps_ideps', 'cantidad_muestras', 'idtipo_servicio', 'idmedico', 'usuario_recibe','medico', 'usuario_transcribe'], 'integer'],
            [['fecha_atencion', 'fecha_informe', 'fecha_salida', 'fecha_entrega', 'periodo_facturacion', 'fecha_inicio', 'fecha_fin'], 'safe'],
            [['valor_procedimiento', 'valor_copago', 'valor_saldo', 'valor_abono', 'descuento'], 'number'],
            [['autorizacion', 'numero_muestra', 'numero_cheque', 'numero_factura'], 'string', 'max' => 15],
            [['cod_cups'], 'string', 'max' => 20],
            [['observaciones'], 'string', 'max' => 200],
            [['forma_pago', 'estado'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idpacientes' => 'Idpacientes',
            'fecha_atencion' => 'Fecha de atención',
            'autorizacion' => 'Autorizacion',
            'numero_muestra' => 'Número de muestra',
            'valor_procedimiento' => 'Valor del procedimiento',
            'eps_ideps' => 'Eps',
            'cod_cups' => 'Código Cups',
            'cantidad_muestras' => 'Cantidad de muestras',
            'valor_copago' => 'Valor Copago',
            'valor_saldo' => 'Valor Saldo',
            'valor_abono' => 'Valor Abono',
            'medico' => 'Medico',
            'observaciones' => 'Observaciones',
            'forma_pago' => 'Forma Pago',
            'numero_cheque' => 'Número Cheque',
            'estado' => 'Estado',
            'fecha_informe' => 'Fecha de informe',
            'numero_factura' => 'Número de factura',
            'fecha_salida' => 'Fecha Salida',
            'fecha_entrega' => 'Fecha Entrega',
            'periodo_facturacion' => 'Periodo de facturacion',
            'idtipo_servicio' => 'Idtipo Servicio',
            'idmedico' => 'Idmedico',
            'usuario_recibe' => 'Usuario Recibe',
            'usuario_transcribe' => 'Usuario Transcribe',
            'descuento' => 'Descuento',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedico0() 
   { 
       return $this->hasOne(MedicosRemitentes::className(), ['id' => 'medico']); 
   } 
 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEpsIdeps()
    {
        return $this->hasOne(Eps::className(), ['id' => 'eps_ideps']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodCups()
    {
        return $this->hasOne(Estudios::className(), ['cod_cups' => 'cod_cups']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdpacientes0()
    {
        return $this->hasOne(Pacientes::className(), ['id' => 'idpacientes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioRecibe()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_recibe']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioTranscribe()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_transcribe']);
    }

    public function getNombreUsuarioTrasncribe()
    {
        try {
            return $this->usuarioTranscribe->nombre;
        } catch (yii\base\ErrorException $e) {
            return 'No definido';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdmedico0()
    {
        return $this->hasOne(Medicos::className(), ['id' => 'idmedico']);
    }

    public function getNombreMedico()
    {
        try {
            return $this->idmedico0->nombre;
        } catch (yii\base\ErrorException $e) {
            return 'No definido';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtipoServicio()
    {
        return $this->hasOne(TiposServicio::className(), ['id' => 'idtipo_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibos()
    {
        return $this->hasMany(Recibos::className(), ['idprocedimiento' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVlrsCamposProcedimientos()
    {
        return $this->hasMany(VlrsCamposProcedimientos::className(), ['id_procedimiento' => 'id']);
    }
}
