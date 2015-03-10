<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TiposServicio;

/**
 * TiposServicioSearch represents the model behind the search form about `app\models\TiposServicio`.
 */
class TiposServicioSearch extends TiposServicio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idips', 'consecutivo'], 'integer'],
            [['nombre', 'serie'], 'safe'],
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
        $query = TiposServicio::find();

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
            'idips' => $this->idips,
            'consecutivo' => $this->consecutivo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'serie', $this->serie]);

        return $dataProvider;
    }
}
