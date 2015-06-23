<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CitasMedicas;

/**
 * CitasMedicasSearch represents the model behind the search form about `app\models\CitasMedicas`.
 */
class CitasMedicasSearch extends CitasMedicas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_citas', 'pacientes_id', 'medicos_id'], 'integer'],
            [['fecha', 'hora', 'observaciones'], 'safe'],
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
        $query = CitasMedicas::find();

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
            'id_citas' => $this->id_citas,
            'pacientes_id' => $this->pacientes_id,
            'medicos_id' => $this->medicos_id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
