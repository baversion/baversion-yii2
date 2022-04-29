<?php

namespace common\models;

use dosamigos\taggable\Taggable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;


/**
 * This is the model class for table "{{%articles}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $article_title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property string $cover_image
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property string $article_status
 * @property integer $lock_to
 * @property integer $view_count
 * @property string $featured
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property ArticleMeta[] $articleMetas
 * @property ArticleTagRelations[] $articleTagRelations
 * @property Tags[] $tags
 * @property Users $author
 */
class Articles extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_CATCH = 'catch';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_PUBLISH = 'publish';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'updated_at', 'published_at', 'lock_to', 'view_count', 'article_status'], 'integer'],
            [['article_title', 'slug', 'created_at', 'updated_at'], 'required'],
            [['excerpt', 'content', 'meta_description'], 'string'],
            [['article_title', 'slug', 'cover_image', 'meta_keywords'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],

            [['id', 'updated_at'], 'required', 'on' => self::SCENARIO_CATCH],
            [['doc_id', 'article_title', 'created_at', 'updated_at'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'article_title', 'updated_at'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['id', 'article_title', 'updated_at', 'published_at'], 'required', 'on' => self::SCENARIO_PUBLISH],

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CATCH] = ['id', 'updated_at'];
        $scenarios[self::SCENARIO_CREATE] = ['doc_id', 'article_title', 'created_at', 'updated_at'];
        $scenarios[self::SCENARIO_UPDATE] = ['id', 'article_title', 'updated_at'];
        $scenarios[self::SCENARIO_PUBLISH] = ['id', 'article_title', 'content', 'updated_at', 'published_at', 'meta_description', 'meta_keywords'];

        return $scenarios;
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'article_title' => 'عنوان',
            'slug' => 'اسلاگ',
            'featured' => 'برجسته',
            'excerpt' => 'چکیده',
            'content' => 'متن',
            'cover_image' => 'عکس کاور',
            'created_at' => 'تاریخ ایجاد',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'article_status' => 'وضعیت پست',
            'lock_to' => 'در اختیار',
            'view_count' => 'تعداد بازدید',
            'meta_keywords' => 'کلمات کلیدی',
            'meta_description' => 'متای توضیحات',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleMetas()
    {
        return $this->hasMany(ArticleMeta::class, ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])->viaTable('{{%taggables}}', ['taggable_type','post', 'taggable_id' => 'id']);
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
     * @return ArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }
}
