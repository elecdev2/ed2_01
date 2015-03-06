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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idpacientes', 'eps_ideps', 'cantidad_muestras', 'idtipo_servicio', 'idmedico', 'usuario_recibe', 'usuario_transcribe', 'idbackup'], 'integer'],
            [['fecha_atencion', 'autorizacion', 'numero_muestra', 'cod_cups', 'medico', 'observaciones', 'forma_pago', 'numero_cheque', 'estado', 'fecha_informe', 'numero_factura', 'fecha_salida', 'fecha_entrega', 'periodo_facturacion'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'idbackup' => $this->idbackup,
        ]);

        $query->andFilterWhere(['like', 'autorizacion', $this->autorizacion])
            ->andFilterWhere(['like', 'numero_muestra', $this->numero_muestra])
            ->andFilterWhere(['like', 'cod_cups', $this->cod_cups])
            ->andFilterWhere(['like', 'medico', $this->medico])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'numero_cheque', $this->numero_cheque])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'numero_factura', $this->numero_factura]);

        return $dataProvider;
    }
}
