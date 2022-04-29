<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property string $id
 * @property int $author_id
 * @property string $tag_name
 * @property string $slug
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property int $last_editor
 * @property int $lock_to
 * @property int $view_count
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $tag_status 0 = trashed, 1 = draft, 2 = pending, 4 = review, 5 = schedule, 6 = published
 *
 * @property Users $author
 * @property Users $lastEditor
 * @property Users $lockTo
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'updated_at', 'published_at', 'last_editor', 'lock_to', 'view_count', 'tag_status'], 'integer'],
            [['tag_name', 'slug', 'created_at', 'updated_at'], 'required'],
            [['content', 'meta_description'], 'string'],
            [['tag_name', 'slug', 'meta_keywords'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['last_editor'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['last_editor' => 'id']],
            [['lock_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['lock_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'tag_name' => 'نام تگ',
            'slug' => 'اسلاگ تگ',
            'content' => 'محتوا',
            'created_at' => 'تاریخ ساخت',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'last_editor' => 'آخرین ویرایش توسط',
            'lock_to' => 'در اختیار',
            'view_count' => 'تعداد بازدید',
            'meta_keywords' => 'کلمات کلیدی',
            'meta_description' => 'متا توضیحات',
            'tag_status' => 'وضعیت',
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
    public function getBlogArticles()
    {
        return $this->hasMany(Articles::class, ['id' => 'article_id'])->viaTable('{{%tag_relations}}', ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditor()
    {
        return $this->hasOne(Users::class, ['id' => 'last_editor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLockTo()
    {
        return $this->hasOne(Users::class, ['id' => 'lock_to']);
    }

    /**
     * {@inheritdoc}
     * @return TagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsQuery(get_called_class());
    }
}
