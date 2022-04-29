<?php
namespace frontend\models;

use common\models\ArticleTagRelations;
use common\models\Tags;
use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\models\Articles;
use common\models\ArticleMeta;

/**
 * Blog post model
 */
class BlogPost extends Model
{
    public $id;
    public $author_id;
    public $article_title;
    public $slug;
    public $excerpt;
    public $content;
    public $cover_image;
    public $created_at;
    public $published_at;
    public $article_status;
    public $meta_keywords;
    public $meta_description;
    public $is_premium;
    public $tags;

    /**
     * @var \common\models\Articles
     */
    private $_article;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'article_title', 'slug', 'content', 'excerpt', 'article_status'], 'required'],
            [['author_id', 'created_at', 'published_at'], 'integer'],
            [['article_title', 'meta_keywords', 'meta_description', 'tags'], 'string'],

            ['slug', 'trim'],
            ['slug', 'string', 'max' => 255],
            ['slug', 'unique', 'targetClass' => '\common\models\Articles', 'message' => 'این اسلاگ قبلا استفاده شده است.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'آی‌دی',
            'author_id' => 'نویسنده',
            'article_title' => 'عنوان پست',
            'slug' => 'اسلاگ',
            'excerpt' => 'خلاصه',
            'content' => 'متن',
            'cover_image' => 'عکس',
            'created_at' => 'تاریخ ساخت',
            'published_at' => 'تاریخ انتشار',
            'article_status' => 'وضعیت',
            'meta_keywords' => 'کلمات کلیدی',
            'meta_description' => 'متای توضیحات',
            'is_premium' => 'ویژه',
            'tags' => 'تگ‌ها',
        ];
    }

    /**
     * Creates a post in the blog.
     * 
     * @return Articles
     */
    public function createPost()
    {
        $articleModel = new Articles();
        $articleModel->author_id = \Yii::$app->user->identity->id;
        $articleModel->article_title = $this->article_title;
        $articleModel->slug = $this->slug;
        $articleModel->content = $this->content;
        $articleModel->excerpt = $this->excerpt;
        $articleModel->meta_keywords = $this->meta_keywords;
        $articleModel->meta_description = $this->meta_description;
        $articleModel->created_at = time();
        if ($this->article_status == 'published')
        {
            $articleModel->published_at = time();
        }

        $articleModel->article_status = $this->article_status;
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $this->content, $image);

        if (isset($image['src']))
        {
            $articleModel->cover_image = $image['src'];
        }

        if ($articleModel->save())
        {
            if ($this->is_premium !== null)
            {
                $metaIsPremium = new ArticleMeta();
                $metaIsPremium->article_id = $articleModel->id;
                $metaIsPremium->meta_key = 'meta_is_premium';
                $metaIsPremium->meta_value = $this->meta_is_premium;
                $metaIsPremium->save();
            }

            $tags = explode(',', $this->tags);
            foreach ($tags as $tag)
            {
                $tagsModel = Tags::find()->where(['tag_name' => $tag])->orWhere(['slug' => $tag])->one();
                $tagModel = new ArticleTagRelations();
                $tagModel->article_id = $articleModel->id;
                $tagModel->tag_id = $tagsModel->id;
                $tagModel->save();
            }
        }

        return $articleModel;
    }

    /**
     * Creates a post in the blog.
     *
     * @return Articles
     */
    public function updatePost()
    {
        $articleModel = Articles::findOne(['id' => $this->id]);
        $articleModel->author_id = \Yii::$app->user->identity->id;
        $articleModel->article_title = $this->article_title;
        $articleModel->slug = $this->slug;
        $articleModel->content = $this->content;
        $articleModel->excerpt = $this->excerpt;
        $articleModel->meta_keywords = $this->meta_keywords;
        $articleModel->meta_description = $this->meta_description;
        $articleModel->created_at = time();
        if ($this->article_status == 'published')
        {
            $articleModel->published_at = time();
        }

        $articleModel->article_status = $this->article_status;
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $this->content, $image);

        if (isset($image['src']))
        {
            $articleModel->cover_image = $image['src'];
        }
        else
        {
            $articleModel->cover_image = null;
        }

        if ($articleModel->save())
        {
            if ($this->is_premium !== null)
            {
                $metaIsPremium = new ArticleMeta();
                $metaIsPremium->article_id = $articleModel->id;
                $metaIsPremium->meta_key = 'meta_is_premium';
                $metaIsPremium->meta_value = $this->meta_is_premium;
                $metaIsPremium->save();
            }

            ArticleTagRelations::deleteAll(['article_id' => $this->id]);

            $tags = explode(',', $this->tags);
            foreach ($tags as $tag)
            {
                $tagsModel = Tags::find()->where(['tag_name' => $tag])->orWhere(['slug' => $tag])->one();
                $tagModel = new ArticleTagRelations();
                $tagModel->article_id = $articleModel->id;
                $tagModel->tag_id = $tagsModel->id;
                $tagModel->save();
            }
        }

        return $articleModel;
    }

    public function findModel($id)
    {
        $model = Articles::find()->where(['id' => $id])->joinWith('');

        return $model;
    }
}
