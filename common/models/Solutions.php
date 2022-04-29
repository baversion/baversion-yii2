<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%solutions}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $solution_title
 * @property string $slug
 * @property string $problem
 * @property string $solution
 * @property string $cover_image
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property int $solution_status
 *
 * @property Users $author
 */
class Solutions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%solutions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'updated_at', 'published_at', 'solution_status'], 'integer'],
            [['solution_title', 'slug', 'created_at', 'updated_at'], 'required'],
            [['problem', 'solution'], 'string'],
            [['solution_title', 'slug', 'cover_image'], 'string', 'max' => 255],
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
            'author_id' => 'نویسنده',
            'solution_title' => 'عنوان سولوشن',
            'slug' => 'اسلاگ',
            'problem' => 'مشکل',
            'solution' => 'راه‌حل',
            'cover_image' => 'عکس',
            'created_at' => 'تارخ ایجاد',
            'updated_at' => 'تاریخ آپدیت',
            'published_at' => 'تاریخ انتشار',
            'solution_status' => 'وضعیت سولوشن',
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
     * {@inheritdoc}
     * @return SolutionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SolutionsQuery(get_called_class());
    }
}
