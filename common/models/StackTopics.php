<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%stack_topics}}".
 *
 * @property string $id
 * @property string $topic_title
 * @property string $slug
 * @property string $content
 * @property string $view_count
 * @property string $author_id
 * @property string $last_editor
 * @property string $last_responder
 * @property string $lock_to
 * @property string $created_at
 * @property string $updated_at
 * @property string $answered_at
 * @property int $accepted
 * @property int $total_votes
 * @property int $total_likes
 * @property int $topic_status
 *
 * @property StackAnswers[] $stackAnswers
 * @property Users $author
 * @property Users $lastEditor
 * @property Users $lastResponder
 * @property Users $lockTo
 */
class StackTopics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stack_topics}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_title', 'slug', 'content', 'author_id', 'created_at', 'updated_at', 'answered_at'], 'required'],
            [['content'], 'string'],
            [['view_count', 'author_id', 'last_editor', 'last_responder', 'lock_to', 'created_at', 'updated_at', 'answered_at', 'accepted', 'total_votes', 'total_likes', 'topic_status'], 'integer'],
            [['topic_title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 50],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['last_editor'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_editor' => 'id']],
            [['last_responder'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_responder' => 'id']],
            [['lock_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['lock_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_title' => 'Topic Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'view_count' => 'View Count',
            'author_id' => 'Author ID',
            'last_editor' => 'Last Editor',
            'last_responder' => 'Last Responder',
            'lock_to' => 'Lock To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'answered_at' => 'Answered At',
            'accepted' => 'Accepted',
            'total_votes' => 'Total Votes',
            'total_likes' => 'Total Likes',
            'topic_status' => 'Topic Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStackAnswers()
    {
        return $this->hasMany(StackAnswers::className(), ['topic_id' => 'id']);
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
    public function getLastResponder()
    {
        return $this->hasOne(Users::className(), ['id' => 'last_responder']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLockTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'lock_to']);
    }

    /**
     * {@inheritdoc}
     * @return StackTopicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StackTopicsQuery(get_called_class());
    }
}
