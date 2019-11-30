<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wine;

/**
 * WineSearch represents the model behind the search form of `app\models\Wine`.
 */
class WineSearch extends Wine
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'points', 'country_id', 'province_id', 'variety_id', 'winery_id'], 'integer'],
            [['description', 'designation'], 'safe'],
            [['price'], 'number'],
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
    public function search($params, $region_id, $variety_id)
    {
        $query = Wine::find();

        if($region_id != null)
        {
            $query->distinct()
            ->innerJoin('wine_region as wr', 'wr.wine_id = wine.id')
            ->where('wr.region_id=:id', ['id' => $region_id]);
        }

        if($variety_id != null)
        {
            $subquery = Variety::find();
            $subquery->select('id')
            ->where('id=:var_id', [':var_id' => $variety_id]);

            $query->where(['variety_id' => $subquery]); 
        }
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
            'points' => $this->points,
            'price' => $this->price,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'variety_id' => $this->variety_id,
            'winery_id' => $this->winery_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'designation', $this->designation]);

        return $dataProvider;
    }
}
