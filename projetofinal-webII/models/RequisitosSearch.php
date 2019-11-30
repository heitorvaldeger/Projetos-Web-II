<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requisitos;
use app\models\Dependentes;
/**
 * RequisitosSearch represents the model behind the search form of `app\models\Requisitos`.
 */
class RequisitosSearch extends Requisitos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nivelPrioridade', 'Projeto_idProjeto'], 'integer'],
            [['nome', 'descricao', 'estado'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $subquery = Requisitos::find()
        ->select('d.Requisitos_idRequisitos_dep')
        ->innerJoin('dependentes d', 'requisitos.id = d.Requisitos_idRequisitos')
        ->where('d.Requisitos_idRequisitos=:id', [':id' => $params["idRequisito"]]);
        $query = Requisitos::find()
        ->where(['requisitos.id' => $subquery]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'nivelPrioridade' => $this->nivelPrioridade,
            'Projeto_idProjeto' => $this->Projeto_idProjeto,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }

    public static function listarRequisitos($idProjeto)
    {
        $query = Requisitos::find('Requisitos.nome, 
        Requisitos.descricao, 
        Requisitos.nivelPrioridade,
        Requisitos.estado')
        ->where('Requisitos.Projeto_idProjeto=:id', [':id' => $idProjeto])
        ->all();

        return $query;
    }
}
