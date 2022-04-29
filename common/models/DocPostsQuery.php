<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DocPosts]].
 *
 * @see DocPosts
 */
class DocPostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DocPosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DocPosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
