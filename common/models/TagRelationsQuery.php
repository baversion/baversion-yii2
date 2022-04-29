<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TagRelations]].
 *
 * @see TagRelations
 */
class TagRelationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TagRelations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TagRelations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
