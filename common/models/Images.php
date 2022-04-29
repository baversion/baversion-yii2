<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property string $id
 * @property string $image_name
 * @property string $image_hash
 * @property string $original_name
 * @property string $user_id
 * @property string $created_at
 *
 * @property Users $user
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_name', 'image_hash', 'original_name', 'user_id', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['image_name', 'original_name'], 'string', 'max' => 255],
            [['image_hash'], 'string', 'max' => 32],
            [['image_name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_name' => 'Image Name',
            'image_hash' => 'Image Hash',
            'original_name' => 'Original Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return ImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImagesQuery(get_called_class());
    }
}
