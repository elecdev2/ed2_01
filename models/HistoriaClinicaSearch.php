<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistoriaClinica;
use app\models\AnalisisImpresionDiagnostica;
use app\models\AnalisisDiag;

/**
 * HistoriaClinicaSearch represents the model behind the search form about `app\models\HistoriaClinica`.
 */
class HistoriaClinicaSearch extends HistoriaClinica
{
    public $paciente;
    public $tipo_servicio;
    public $medico;
    public $diag;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_tipos', 'id_medico'], 'integer'],
            [['fecha', 'hora', 'paciente', 'tipo_servicio', 'medico', 'diag'], 'safe'],
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
    public function search($params, $cod)
    {
        $query = HistoriaClinica::find();
        
        if($cod !== 0)
        {
            $subquery = AnalisisImpresionDiagnostica::find()->select(['id_analisis'])->where(['id_cod'=>$cod]);
            $subquery2 = AnalisisDiag::find()->select(['id_historia'])->where(['analisis_diag.id'=>$subquery]);
            $query->where(['historia_clinica.id'=>$subquery2]);
        }

        $query->joinWith(['idMedico', 'idPaciente', 'idTipos']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['fecha'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['medico'] = [
            'asc'=>['medicos.nombre'=>SORT_ASC],
            'desc'=>['medicos.nombre'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['paciente'] = [
            'asc'=>['pacientes.identificacion'=>SORT_ASC],
            'desc'=>['pacientes.identificacion'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['tipo_servicio'] = [
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
            'id' => $this->id,
            'id_paciente' => $this->id_paciente,
            'id_tipos' => $this->id_tipos,
            'fecha' => $this->fecha,
            'id_medico' => $this->id_medico,
        ]);

         $query->andFilterWhere(['like', 'hora', $this->hora])
            ->andFilterWhere(['like', 'medicos.nombre', $this->medico])
            ->andFilterWhere(['like', 'pacientes.identificacion', $this->paciente])
            ->andFilterWhere(['like', 'tipos_servicio.nombre', $this->tipo_servicio]);

        $query->limit(20);

        return $dataProvider;
    }
}
