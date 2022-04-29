<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Solutions;

/**
 * SolutionsSearch represents the model behind the search form of `common\models\Solutions`.
 */
class SolutionsSearch extends Solutions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'created_at', 'updated_at', 'published_at', 'solution_status'], 'integer'],
            [['solution_title', 'slug', 'problem', 'solution', 'cover_image'], 'safe'],
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
        $query = Solutions::find();

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
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'published_at' => $this->published_at,
            'solution_status' => $this->solution_status,
        ]);

        $query->andFilterWhere(['like', 'solution_title', $this->solution_title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'problem', $this->problem])
            ->andFilterWhere(['like', 'solution', $this->solution])
            ->andFilterWhere(['like', 'cover_image', $this->cover_image]);

        return $dataProvider;
    }
}
