<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%stack_answers}}".
 *
 * @property string $id
 * @property string $topic_id
 * @property string $content
 * @property string $author_id
 * @property string $last_editor
 * @property string $lock_to
 * @property string $created_at
 * @property string $updated_at
 * @property string $accepted_at
 * @property int $accepted
 * @property int $total_votes
 * @property int $total_likes
 * @property int $answer_status
 *
 * @property Users $author
 * @property Users $lastEditor
 * @property Users $lockTo
 * @property StackTopics $topic
 */
class StackAnswers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stack_answers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_id', 'content', 'author_id', 'created_at', 'updated_at'], 'required'],
            [['topic_id', 'author_id', 'last_editor', 'lock_to', 'created_at', 'updated_at', 'accepted_at', 'accepted', 'total_votes', 'total_likes', 'answer_status'], 'integer'],
            [['content'], 'string'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['last_editor'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_editor' => 'id']],
            [['lock_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['lock_to' => 'id']],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => StackTopics::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'Topic ID',
            'content' => 'Content',
            'author_id' => 'Author ID',
            'last_editor' => 'Last Editor',
            'lock_to' => 'Lock To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'accepted_at' => 'Accepted At',
            'accepted' => 'Accepted',
            'total_votes' => 'Total Votes',
            'total_likes' => 'Total Likes',
            'answer_status' => 'Answer Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditor()
    {
        return $this->hasOne(Users::className(), ['id' => 'last_editor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLockTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'lock_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(StackTopics::className(), ['id' => 'topic_id']);
    }

    /**
     * {@inheritdoc}
     * @return StackAnswersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StackAnswersQuery(get_called_class());
    }
}
