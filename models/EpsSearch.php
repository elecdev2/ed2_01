<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Eps;

/**
 * EpsSearch represents the model behind the search form about `app\models\Eps`.
 */
class EpsSearch extends Eps
{
    public $ips;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idips', 'generar_rip', 'idinformes', 'activo'], 'integer'],
            [['codigo', 'nombre', 'direccion', 'telefono', 'nit','ips'], 'safe'],
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
        $query = Eps::find();

        $query->joinWith(['idips0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['ips'] = [
            'asc'=>['ips.nombre'=>SORT_ASC],
            'desc'=>['ips.nombre'=>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idips' => $this->idips,
            'generar_rip' => $this->generar_rip,
            'idinformes' => $this->idinformes,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'ips.nombre', $this->ips])
            ->andFilterWhere(['like', 'nit', $this->nit]);

        $query->limit(20);

        return $dataProvider;
    }
}
