<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%docs}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $doc_title
 * @property string $subtitle
 * @property string $slug
 * @property string $content
 * @property string $version
 * @property string $doc_version
 * @property string $cover_image
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property string $doc_status
 * @property integer $completed
 * @property integer $deprecated
 * @property integer $lock_to
 * @property integer $premium
 * @property integer $view_count
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property DocPosts[] $docPosts
 * @property Users $author
 */
class Docs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%docs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'updated_at', 'published_at', 'lock_to', 'view_count'], 'integer'],
            [['doc_title', 'slug', 'version', 'doc_version', 'created_at', 'updated_at'], 'required'],
            [['completed', 'deprecated', 'premium'], 'boolean'],
            [['content', 'doc_status', 'meta_description', 'subtitle'], 'string'],
            [['doc_title', 'slug', 'cover_image', 'meta_keywords'], 'string', 'max' => 255],
            [['version', 'doc_version'], 'string', 'max' => 10],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'نویسنده',
            'doc_title' => 'عنوان',
            'subtitle' => 'زیرعنوان',
            'slug' => 'اسلاگ',
            'content' => 'محتوا',
            'version' => 'آخرین ورژن',
            'doc_version' => 'ورژن داکیومنت',
            'cover_image' => 'عکس',
            'created_at' => 'تاریخ ایجاد',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'doc_status' => 'وضعیت',
            'completed' => 'ترجمه داکیومنت به صورت کامل انجام شده است',
            'deprecated' => 'داکیومنت منسوخ شده است',
            'lock_to' => 'در اختیار',
            'view_count' => 'تعداد بازدید',
            'meta_keywords' => 'کلمات کلیدی',
            'meta_description' => 'متای توضیحات',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocPosts()
    {
        return $this->hasMany(DocPosts::class, ['doc_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    /**
     * @inheritdoc
     * @return DocsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocsQuery(get_called_class());
    }
}
