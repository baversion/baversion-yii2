<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%doc_posts}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $doc_id
 * @property string $post_title
 * @property string $slug
 * @property string $content
 * @property string $src
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property string $parent_id
 * @property integer $post_order
 * @property string $post_status
 * @property integer $lock_to
 * @property integer $view_count
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Users $author
 * @property Docs $doc
 * @property DocPosts $parent
 * @property DocPosts[] $docPosts
 */
class DocPosts extends \yii\db\ActiveRecord
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
        return '{{%doc_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'doc_id', 'created_at', 'updated_at', 'published_at', 'parent_id', 'post_order', 'lock_to', 'view_count'], 'integer'],
            [['content', 'post_status', 'meta_description'], 'string'],
            [['post_title', 'slug', 'src', 'meta_keywords'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Docs::class, 'targetAttribute' => ['doc_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocPosts::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['id', 'updated_at'], 'required', 'on' => self::SCENARIO_CATCH],
            [['doc_id', 'post_title', 'created_at', 'updated_at'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'doc_id', 'post_title', 'updated_at'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['id', 'doc_id', 'post_title', 'post_order', 'updated_at', 'published_at'], 'required', 'on' => self::SCENARIO_PUBLISH],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CATCH] = ['updated_at'];
        $scenarios[self::SCENARIO_CREATE] = ['doc_id', 'post_title', 'created_at', 'updated_at', 'src'];
        $scenarios[self::SCENARIO_UPDATE] = ['doc_id', 'post_title', 'updated_at', 'content'];
        $scenarios[self::SCENARIO_PUBLISH] = ['doc_id', 'post_title', 'content', 'updated_at', 'published_at', 'meta_description', 'meta_keywords'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'doc_id' => 'Doc ID',
            'post_title' => 'Post Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'src' => 'Src',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'published_at' => 'Published At',
            'parent_id' => 'Parent ID',
            'post_order' => 'Post Order',
            'post_status' => 'Post Status',
            'lock_to' => 'در اختیار',
            'view_count' => 'تعداد بازدید',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
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
    public function getDoc()
    {
        return $this->hasOne(Docs::class, ['id' => 'doc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DocPosts::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocPosts()
    {
        return $this->hasMany(DocPosts::class, ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DocPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocPostsQuery(get_called_class());
    }
}
