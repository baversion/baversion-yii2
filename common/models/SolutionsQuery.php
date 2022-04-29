<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Solutions]].
 *
 * @see Solutions
 */
class SolutionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Solutions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Solutions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
