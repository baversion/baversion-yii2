<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Docs;

/**
 * DocsSearch represents the model behind the search form of `common\models\Docs`.
 */
class DocsSearch extends Docs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'created_at', 'updated_at', 'published_at', 'doc_status', 'completed', 'deprecated', 'lock_to'], 'integer'],
            [['doc_title', 'subtitle', 'slug', 'content', 'version', 'doc_version', 'cover_image', 'meta_keywords', 'meta_description'], 'safe'],
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
        $query = Docs::find();

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
            'doc_status' => $this->doc_status,
            'completed' => $this->completed,
            'deprecated' => $this->deprecated,
            'lock_to' => $this->lock_to,
        ]);

        $query->andFilterWhere(['like', 'doc_title', $this->doc_title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'doc_version', $this->doc_version])
            ->andFilterWhere(['like', 'cover_image', $this->cover_image])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description]);

        return $dataProvider;
    }
}
