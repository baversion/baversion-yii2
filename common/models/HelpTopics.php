<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_topics}}".
 *
 * @property string $id
 * @propertyint $author_id
 * @property string $topic_title
 * @property string $slug
 * @property int $created_at
 * @property int $updated_at
 *
 * @property HelpPosts[] $helpPosts
 * @property Users $author
 */
class HelpTopics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_topics}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'topic_title', 'slug', 'created_at', 'updated_at'], 'required'],
            [['author_id', 'created_at', 'updated_at'], 'integer'],
            [['topic_title', 'slug'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'ایجاد کننده',
            'topic_title' => 'عنوان تاپیک',
            'slug' => 'اسلاگ',
            'created_at' => 'تاریخ ساخت',
            'updated_at' => 'تاریخ آپدیت',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpPosts()
    {
        return $this->hasMany(HelpPosts::class, ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    /**
     * {@inheritdoc}
     * @return HelpTopicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HelpTopicsQuery(get_called_class());
    }
}
