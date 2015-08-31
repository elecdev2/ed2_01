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
    public $nombre1;
    public $nombre2;
    public $apellido1;
    public $apellido2;
    public $motivo;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_citas', 'pacientes_id', 'medicos_id','tipo_servicio'], 'integer'],
            [['fecha', 'hora', 'observaciones', 'hora_llegada', 'estado','medico','id_pac', 'motivo','nombre1','nombre2','apellido1','apellido2'], 'safe'],
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

        $query->joinWith(['medicos', 'pacientes', 'tipoServicio']);

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

        $dataProvider->sort->attributes['nombre1'] = [
            'asc'=>['pacientes.nombre1'=>SORT_ASC],
            'desc'=>['pacientes.nombre1'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['nombre2'] = [
            'asc'=>['pacientes.nombre2'=>SORT_ASC],
            'desc'=>['pacientes.nombre2'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['apellido1'] = [
            'asc'=>['pacientes.apellido1'=>SORT_ASC],
            'desc'=>['pacientes.apellido1'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['apellido2'] = [
            'asc'=>['pacientes.apellido2'=>SORT_ASC],
            'desc'=>['pacientes.apellido2'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['motivo'] = [
            'asc'=>['tipos_servicio.nombre'=>SORT_ASC],
            'desc'=>['tipos_servicio.nombre'=>SORT_DESC],
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
            'tipo_servicio'=>$this->tipo_servicio,
            // 'hora' => $this->hora,
            'hora_llegada' => $this->hora_llegada,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'medicos.nombre', $this->medico])
            ->andFilterWhere(['like', 'pacientes.identificacion', $this->id_pac])
            ->andFilterWhere(['like', 'hora', $this->hora])
            ->andFilterWhere(['like', 'tipos_servicio.nombre', $this->motivo])
            ->andFilterWhere(['like', 'pacientes.nombre1', $this->nombre1])
            ->andFilterWhere(['like', 'pacientes.nombre2', $this->nombre2])
            ->andFilterWhere(['like', 'pacientes.apellido1', $this->apellido1])
            ->andFilterWhere(['like', 'pacientes.apellido2', $this->apellido2])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        $query->limit(20);

        return $dataProvider;
    }
}
