<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_posts}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $topic_id
 * @property string $post_title
 * @property string $slug
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property int $help_status
 * @property string $lock_to
 *
 * @property Users $author
 * @property Users $lockTo
 * @property HelpTopics $topic
 */
class HelpPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'post_title', 'slug', 'created_at', 'updated_at'], 'required'],
            [['author_id', 'topic_id', 'created_at', 'updated_at', 'published_at', 'help_status', 'lock_to'], 'integer'],
            [['content'], 'string'],
            [['post_title', 'slug'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['lock_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['lock_to' => 'id']],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpTopics::class, 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'نویسنده',
            'topic_id' => 'تاپیک',
            'post_title' => 'عنوان پست',
            'slug' => 'اسلاگ',
            'content' => 'محتوا',
            'created_at' => 'تاریخ ایجاد',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'help_status' => 'وضعیت انتشار',
            'lock_to' => 'Lock To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLockTo()
    {
        return $this->hasOne(Users::class, ['id' => 'lock_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(HelpTopics::class, ['id' => 'topic_id']);
    }

    /**
     * {@inheritdoc}
     * @return HelpPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HelpPostsQuery(get_called_class());
    }
}
