<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Terminology]].
 *
 * @see Terminology
 */
class TerminologyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Terminology[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Terminology|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
