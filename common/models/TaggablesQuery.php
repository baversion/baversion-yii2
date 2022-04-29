<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Taggables]].
 *
 * @see Taggables
 */
class TaggablesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Taggables[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Taggables|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
