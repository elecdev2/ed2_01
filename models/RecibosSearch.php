<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recibos;

/**
 * RecibosSearch represents the model behind the search form about `app\models\Recibos`.
 */
class RecibosSearch extends Recibos
{
    public $num_muestra;
    public $nombre_usuario;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idprocedimiento', 'num_recibo', 'idusuario'], 'integer'],
            [['valor_saldo', 'valor_abono'], 'number'],
            [['fecha','num_muestra','nombre_usuario'], 'safe'],
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
        $query = Recibos::find();

        $query->joinWith(['idprocedimiento0', 'idusuario0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['num_muestra'] =[
            'asc'=>['procedimientos.numero_muestra'=>SORT_ASC],
            'desc'=>['procedimientos.numero_muestra'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['nombre_usuario'] =[
            'asc'=>['usuarios.nombre'=>SORT_ASC],
            'desc'=>['usuarios.nombre'=>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idprocedimiento' => $this->idprocedimiento,
            'num_recibo' => $this->num_recibo,
            'valor_saldo' => $this->valor_saldo,
            'valor_abono' => $this->valor_abono,
            'idusuario' => $this->idusuario,
            'fecha' => $this->fecha,
        ]);
        $query->andFilterWhere(['like', 'procedimientos.numero_muestra', $this->num_muestra])
            ->andFilterWhere(['like', 'usuarios.nombre', $this->nombre_usuario]);

        $query->limit(20);

        return $dataProvider;
    }
}
