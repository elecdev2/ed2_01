<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistoriaClinica;

/**
 * HistoriaClinicaSearch represents the model behind the search form about `app\models\HistoriaClinica`.
 */
class HistoriaClinicaSearch extends HistoriaClinica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_tipos', 'id_medico'], 'integer'],
            [['fecha', 'hora'], 'safe'],
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
        $query = HistoriaClinica::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_paciente' => $this->id_paciente,
            'id_tipos' => $this->id_tipos,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'id_medico' => $this->id_medico,
        ]);

        return $dataProvider;
    }
}
