<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tag_relations}}".
 *
 * @property string $object_type
 * @property string $object_id
 * @property string $tag_id
 * @property string $user_id
 * @property string $created_at
 *
 * @property Users $user
 */
class TagRelations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag_relations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_type', 'object_id', 'tag_id', 'user_id', 'created_at'], 'required'],
            [['object_id', 'tag_id', 'user_id', 'created_at'], 'integer'],
            ['object_type', 'string'],
            [['object_type', 'object_id', 'tag_id'], 'unique', 'targetAttribute' => ['object_type', 'object_id', 'tag_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object_type' => 'Object Type',
            'object_id' => 'Object ID',
            'tag_id' => 'Tag ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasMany(Articles::class, ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return TagRelationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagRelationsQuery(get_called_class());
    }
}
