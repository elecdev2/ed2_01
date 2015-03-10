<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ips;

/**
 * IpsSearch represents the model behind the search form about `app\models\Ips`.
 */
class IpsSearch extends Ips
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idclientes', 'activo', 'consecutivo_fact', 'consecutivo_recibo'], 'integer'],
            [['codigo', 'nombre', 'direccion', 'tipo_identificacion', 'nit', 'telefono', 'representante_legal', 'descripcion', 'mensaje_email'], 'safe'],
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
        $query = Ips::find();

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
            'idclientes' => $this->idclientes,
            'activo' => $this->activo,
            'consecutivo_fact' => $this->consecutivo_fact,
            'consecutivo_recibo' => $this->consecutivo_recibo,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'tipo_identificacion', $this->tipo_identificacion])
            ->andFilterWhere(['like', 'nit', $this->nit])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'representante_legal', $this->representante_legal])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'mensaje_email', $this->mensaje_email]);

        return $dataProvider;
    }
}
