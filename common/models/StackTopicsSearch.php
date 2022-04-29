<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StackTopics;

/**
 * StackTopicsSearch represents the model behind the search form of `common\models\StackTopics`.
 */
class StackTopicsSearch extends StackTopics
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'view_count', 'author_id', 'last_editor', 'last_responder', 'lock_to', 'created_at', 'updated_at', 'answered_at', 'accepted', 'total_votes', 'total_likes', 'topic_status'], 'integer'],
            [['topic_title', 'slug', 'content'], 'safe'],
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
        $query = StackTopics::find();

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
            'view_count' => $this->view_count,
            'author_id' => $this->author_id,
            'last_editor' => $this->last_editor,
            'last_responder' => $this->last_responder,
            'lock_to' => $this->lock_to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'answered_at' => $this->answered_at,
            'accepted' => $this->accepted,
            'total_votes' => $this->total_votes,
            'total_likes' => $this->total_likes,
            'topic_status' => $this->topic_status,
        ]);

        $query->andFilterWhere(['like', 'topic_title', $this->topic_title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
