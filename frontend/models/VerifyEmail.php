<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * VerifyEmail is the model behind the email verification form.
 */
class VerifyEmail extends Model
{
    public $email;
    public $token;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'token'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'ایمیل',
            'token' => 'توکن',
        ];
    }
}
