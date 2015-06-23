<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Procedimientos;

/**
 * ProcedimientosSearch represents the model behind the search form about `app\models\Procedimientos`.
 */
class ProcedimientosSearch extends Procedimientos
{
    public $eps;
    public $numid_paciente;
    public $tipo_servicio;
    public $medico;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idpacientes', 'eps_ideps', 'cantidad_muestras', 'idtipo_servicio', 'idmedico', 'usuario_recibe', 'usuario_transcribe'], 'integer'],
            [['eps','numid_paciente','tipo_servicio','medico','fecha_atencion', 'autorizacion', 'numero_muestra', 'cod_cups', 'medico', 'observaciones', 'forma_pago', 'numero_cheque', 'estado', 'fecha_informe', 'numero_factura', 'fecha_salida', 'fecha_entrega', 'periodo_facturacion'], 'safe'],
            [['valor_procedimiento', 'valor_copago', 'valor_saldo', 'valor_abono', 'descuento'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Procedimientos::find();

        $query->joinWith(['idpacientes0', 'epsIdeps','idmedico0','idtipoServicio']);

        $query->where(['eps.idips'=>UsuariosIps::find()->select('idips')->where(['idusuario'=>Yii::$app->user->id])]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['eps'] =[
            'asc'=>['eps.nombre'=>SORT_ASC],
            'desc'=>['eps.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['numid_paciente'] =[
            'asc'=>['pacientes.identificacion'=>SORT_ASC],
            'desc'=>['pacientes.identificacion'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['tipo_servicio'] =[
            'asc'=>['tipos_servicio.nombre'=>SORT_ASC],
            'desc'=>['tipos_servicio.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['medico'] =[
            'asc'=>['medicos.nombre'=>SORT_ASC],
            'desc'=>['medicos.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['usuario_recibe'] =[
            'asc'=>['usaurios.nombre'=>SORT_ASC],
            'desc'=>['usaurios.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['usuario_transcribe'] =[
            'asc'=>['usaurios.nombre'=>SORT_ASC],
            'desc'=>['usaurios.nombre'=>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idpacientes' => $this->idpacientes,
            'fecha_atencion' => $this->fecha_atencion,
            'valor_procedimiento' => $this->valor_procedimiento,
            'eps_ideps' => $this->eps_ideps,
            'cantidad_muestras' => $this->cantidad_muestras,
            'valor_copago' => $this->valor_copago,
            'valor_saldo' => $this->valor_saldo,
            'valor_abono' => $this->valor_abono,
            'fecha_informe' => $this->fecha_informe,
            'fecha_salida' => $this->fecha_salida,
            'fecha_entrega' => $this->fecha_entrega,
            'periodo_facturacion' => $this->periodo_facturacion,
            'idtipo_servicio' => $this->idtipo_servicio,
            'idmedico' => $this->idmedico,
            'usuario_recibe' => $this->usuario_recibe,
            'usuario_transcribe' => $this->usuario_transcribe,
            'descuento' => $this->descuento,
        ]);

        $query->andFilterWhere(['like', 'autorizacion', $this->autorizacion])
            ->andFilterWhere(['like', 'numero_muestra', $this->numero_muestra])
            ->andFilterWhere(['like', 'cod_cups', $this->cod_cups])
            ->andFilterWhere(['like', 'medico', $this->medico])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'numero_cheque', $this->numero_cheque])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'eps.nombre', $this->eps])
            ->andFilterWhere(['like', 'pacientes.identificacion', $this->numid_paciente])
            ->andFilterWhere(['like', 'medicos.nombre', $this->medico])
            ->andFilterWhere(['like', 'tipos_servicio.nombre', $this->tipo_servicio])
            ->andFilterWhere(['like', 'numero_factura', $this->numero_factura]);

        $query->limit(20);

        return $dataProvider;
    }
}
