<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pacientes;

/**
 * PacientesSearch represents the model behind the search form about `app\models\Pacientes`.
 */
class PacientesSearch extends Pacientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idclientes', 'activo', 'idciudad', 'ideps', 'envia_email'], 'integer'],
            [['tipo_identificacion', 'identificacion', 'apellido1', 'nombre1', 'nombre2', 'apellido2', 'direccion', 'telefono', 'sexo', 'fecha_nacimiento', 'tipo_usuario', 'tipo_residencia', 'email', 'codeps'], 'safe'],
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
        $query = Pacientes::find()->where(['idclientes'=>Usuarios::findOne(Yii::$app->user->id)->idclientes]);

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'idclientes' => $this->idclientes,
            'activo' => $this->activo,
            'idciudad' => $this->idciudad,
            'ideps' => $this->ideps,
            'envia_email' => $this->envia_email,
        ]);

        $query->andFilterWhere(['like', 'tipo_identificacion', $this->tipo_identificacion])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'apellido1', $this->apellido1])
            ->andFilterWhere(['like', 'nombre1', $this->nombre1])
            ->andFilterWhere(['like', 'nombre2', $this->nombre2])
            ->andFilterWhere(['like', 'apellido2', $this->apellido2])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'tipo_usuario', $this->tipo_usuario])
            ->andFilterWhere(['like', 'tipo_residencia', $this->tipo_residencia])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'codeps', $this->codeps]);

        $query->limit(20);

        return $dataProvider;
    }
}
