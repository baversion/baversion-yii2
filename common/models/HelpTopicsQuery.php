<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HelpTopics]].
 *
 * @see HelpTopics
 */
class HelpTopicsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return HelpTopics[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return HelpTopics|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
