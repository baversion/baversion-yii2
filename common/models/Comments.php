<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $object_type
 * @property string $object_id
 * @property string $content
 * @property string $created_at
 * @property string $author_ip
 * @property string $parent_id
 * @property int $comment_status
 *
 * @property Users $author
 * @property Comments $parent
 * @property Comments[] $comments
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'object_type', 'object_id', 'created_at', 'author_ip', 'parent_id'], 'required'],
            [['author_id', 'object_id', 'created_at', 'author_ip', 'parent_id', 'comment_status'], 'integer'],
            [['content'], 'string'],
            [['object_type'], 'string', 'max' => 20],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'object_type' => 'Object Type',
            'object_id' => 'Object ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'author_ip' => 'Author Ip',
            'parent_id' => 'Parent ID',
            'comment_status' => 'Comment Status',
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
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comments::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['parent_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentsQuery(get_called_class());
    }
}
