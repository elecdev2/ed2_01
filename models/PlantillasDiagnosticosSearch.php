<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlantillasDiagnosticos;
use app\models\Usuarios;

/**
 * PlantillasDiagnosticosSearch represents the model behind the search form about `app\models\PlantillasDiagnosticos`.
 */
class PlantillasDiagnosticosSearch extends PlantillasDiagnosticos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_medico'], 'integer'],
            [['titulo', 'descripcion'], 'safe'],
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
        $query = PlantillasDiagnosticos::find()->where(['id_medico'=>Usuarios::findOne(Yii::$app->user->id)->idmedicos]);

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
            'id_medico' => $this->id_medico,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
