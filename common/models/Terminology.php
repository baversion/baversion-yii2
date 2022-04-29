<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%terminologies}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $term_title
 * @property string $slug
 * @property string $content
 * @property string $initial
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property string $last_editor
 * @property string $lock_to
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $term_status
 *
 * @property Users $author
 * @property Users $lastEditor
 * @property Users $lockTo
 */
class Terminology extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%terminologies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'updated_at', 'published_at', 'last_editor', 'lock_to', 'term_status'], 'integer'],
            [['term_title', 'created_at', 'updated_at'], 'required'],
            [['content', 'meta_description'], 'string'],
            [['term_title', 'slug', 'meta_keywords'], 'string', 'max' => 255],
            [['initial'], 'string', 'max' => 2],
            [['slug'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['last_editor'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['last_editor' => 'id']],
            [['lock_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['lock_to' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function() { return date('U');},//new \yii\db\Expression('NOW()'),
            ],
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
            'term_title' => 'عنوان اصطلاح فنی',
            'slug' => 'اسلاگ',
            'content' => 'متن',
            'initial' => 'حرف اول',
            'created_at' => 'تاریخ ایجاد',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'last_editor' => 'آخرین ویرایشگر',
            'lock_to' => 'در اختیار',
            'meta_keywords' => 'کلمات کلیدی',
            'meta_description' => 'متای توضیحات',
            'term_status' => 'وضعیت',
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
     * @return TerminologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TerminologyQuery(get_called_class());
    }
}
