<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Medicos;

/**
 * MedicosSearch represents the model behind the search form about `app\models\Medicos`.
 */
class MedicosSearch extends Medicos
{

    public $ips;
    public $especialidad;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ips_idips', 'idespecialidades', 'id', 'idclientes'], 'integer'],
            [['codigo', 'nombre', 'ruta_firma','ips','especialidad'], 'safe'],
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
        $query = Medicos::find();

        $query->joinWith(['idespecialidades0', 'ipsIdips']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['ips'] = [
            'asc'=>['ips.nombre'=>SORT_ASC],
            'desc'=>['ips.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['especialidad'] = [
            'asc'=>['especialidades.nombre'=>SORT_ASC],
            'desc'=>['especialidades.nombre'=>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ips_idips' => $this->ips_idips,
            'idespecialidades' => $this->idespecialidades,
            'id' => $this->id,
            'idclientes' => $this->idclientes,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'ips.nombre', $this->ips])
            ->andFilterWhere(['like', 'especialidades.nombre', $this->especialidad])
            ->andFilterWhere(['like', 'ruta_firma', $this->ruta_firma]);

        $query->limit(20);

        return $dataProvider;
    }
}
