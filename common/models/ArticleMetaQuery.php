<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ArticleMeta]].
 *
 * @see ArticleMeta
 */
class ArticleMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ArticleMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ArticleMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
