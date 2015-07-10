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
    public $medico;
    public $id_pac;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_citas', 'pacientes_id', 'medicos_id'], 'integer'],
            [['fecha', 'hora', 'observaciones', 'hora_llegada', 'motivo', 'estado','medico','id_pac'], 'safe'],
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

        $query->joinWith(['medicos', 'pacientes']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['medico'] = [
            'asc'=>['medicos.nombre'=>SORT_ASC],
            'desc'=>['medicos.nombre'=>SORT_DESC],
        ];


        $dataProvider->sort->attributes['id_pac'] = [
            'asc'=>['pacientes.identificacion'=>SORT_ASC],
            'desc'=>['pacientes.identificacion'=>SORT_DESC],
        ];

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
            'hora_llegada' => $this->hora_llegada,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'motivo', $this->motivo])
            ->andFilterWhere(['like', 'medicos.nombre', $this->medico])
            ->andFilterWhere(['like', 'pacientes.identificacion', $this->id_pac])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        $query->limit(20);

        return $dataProvider;
    }
}
