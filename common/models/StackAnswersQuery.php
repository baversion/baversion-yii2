<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StackAnswers]].
 *
 * @see StackAnswers
 */
class StackAnswersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StackAnswers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StackAnswers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
