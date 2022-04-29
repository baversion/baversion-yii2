<?php

namespace common\models;

use phpDocumentor\Reflection\DocBlock\Tag;
use Yii;

/**
 * This is the model class for table "{{%taggables}}".
 *
 * @property string $taggable_type
 * @property string $taggable_id
 * @property string $tag_id
 */
class Taggables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%taggables}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taggable_type', 'taggable_id', 'tag_id'], 'required'],
            [['taggable_id', 'tag_id'], 'integer'],
            [['taggable_type'], 'string', 'max' => 255],
            [['taggable_type', 'taggable_id', 'tag_id'], 'unique', 'targetAttribute' => ['taggable_type', 'taggable_id', 'tag_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'taggable_type' => 'Taggable Type',
            'taggable_id' => 'Taggable ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaggablesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaggablesQuery(get_called_class());
    }

    public function getTag() {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

    public function getArticle() {
        return $this->hasOne(Articles::class, ['id' => 'taggable_id']);
    }
}
