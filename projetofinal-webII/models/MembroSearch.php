<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Membro;

/**
 * MembroSearch represents the model behind the search form of `app\models\Membro`.
 */
class MembroSearch extends Membro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'email', 'senha', 'access_token', 'auth_key'], 'safe'],
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
        $query = Membro::find();

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
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'senha', $this->senha])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }

    public function listarMembros($idEquipe)
    {
        $subquery = Equipe::find();
        $subquery->select('equipe.id')
        ->where('equipe.id=:idEquipe', [':idEquipe' => $idEquipe]);


        $query = self::find()
        ->select("Membro.id, Membro.nome, Membro.email, Membro_Equipe.Membro_administrador")
        ->innerJoin('Membro_Equipe', 'Membro_Equipe.Membro_id = Membro.id')
        ->asArray()
        ->where(['Membro_Equipe.Equipe_idEquipe' => $subquery])
        ->all();

        return $query;
    }
}
