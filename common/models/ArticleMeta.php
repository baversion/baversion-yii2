<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_meta}}".
 *
 * @property string $id
 * @property string $article_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Articles $article
 */
class ArticleMeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_meta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'meta_key'], 'required'],
            [['article_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticleMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleMetaQuery(get_called_class());
    }
}
