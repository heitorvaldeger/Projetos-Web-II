<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projeto;

/**
 * ProjetoSearch represents the model behind the search form of `app\models\Projeto`.
 */
class ProjetoSearch extends Projeto
{
    /**
     * Exemplo de atributo utilizado para capturar uma coluna(campo) de outra
     * tabela do Inner Join
     */
    public $nomeEquipe;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Cliente_idCliente', 'Equipe_idEquipe'], 'integer'],
            [['nome', 'descricao'], 'safe'],
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
    public function search($params, $idEquipe) 
    {
        $query = ProjetoSearch::find();

        $query->select('Projeto.*, Equipe.nomeOrganizacao as nomeEquipe')
        ->innerJoin('Equipe', 'Projeto.Equipe_IdEquipe = Equipe.id')
        ->where('Equipe.id=:id', [':id' => $idEquipe]);

        // $query->select(['Projeto.*', 'Equipe.id as equipe'])
        //     ->innerJoin('Equipe', 'Projeto.equipe_idEquipe = Equipe.id');
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
            'Cliente_idCliente' => $this->Cliente_idCliente,
            'Equipe_idEquipe' => $this->Equipe_idEquipe,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
