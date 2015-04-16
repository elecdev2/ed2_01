<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tarifas;

/**
 * TarifasSearch represents the model behind the search form about `app\models\Tarifas`.
 */
class TarifasSearch extends Tarifas
{
    public $estudio;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'eps_id'], 'integer'],
            [['estudio'], 'safe'],
            [['valor_procedimiento', 'descuento'], 'number'],
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
    public function search($params,$ideps)
    {
        $query = Tarifas::find()->where(['eps_id'=>$ideps]);

        $query->joinWith(['idestudios0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['estudio'] = [
            'asc'=>['estudio.descripcion'=>SORT_ASC],
            'desc'=>['estudio.descripcion'=>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'eps_id' => $this->eps_id,
            'valor_procedimiento' => $this->valor_procedimiento,
            'descuento' => $this->descuento,
        ]);

        $query->andFilterWhere(['like', 'estudios.descripcion', $this->estudio]);
        $query->andFilterWhere(['like', 'idestudios', $this->idestudios]);

        return $dataProvider;
    }
}
