<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Campos;

/**
 * CamposSearch represents the model behind the search form about `app\models\Campos`.
 */
class CamposSearch extends Campos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idtipos_servicio', 'titulos_idtitulos', 'orden'], 'integer'],
            [['tipo_campo', 'nombre_campo'], 'safe'],
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
        $query = Campos::find();

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
            'idtipos_servicio' => $this->idtipos_servicio,
            'titulos_idtitulos' => $this->titulos_idtitulos,
            'orden' => $this->orden,
        ]);

        $query->andFilterWhere(['like', 'tipo_campo', $this->tipo_campo])
            ->andFilterWhere(['like', 'nombre_campo', $this->nombre_campo]);

        return $dataProvider;
    }
}
