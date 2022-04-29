<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HelpPosts]].
 *
 * @see HelpPosts
 */
class HelpPostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return HelpPosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return HelpPosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
