<?php
namespace frontend\models;

use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $display_name;
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['display_name', 'trim'],
            ['display_name', 'required'],
            ['display_name', 'string', 'min' => 2, 'max' => 30],

//            ['username', 'trim'],
//            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This username has already been taken.'],
//            ['username', 'string', 'min' => 2, 'max' => 25],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'قبلا کاربری با این ایمیل ثبت‌نام کرده است.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'آی‌دی',
            'display_name' => 'نام نمایشی',
            'username' => 'یوزرنیم',
            'email' => 'ایمیل',
            'password' => 'پسورد',
            'image' => 'عکس',
            'created_at' => 'تاریخ ثبت نام',
            'updated_at' => 'تاریخ آخرین آپدیت پروفایل'
        ];
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Users();
        $user->display_name = $this->display_name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailAuthKey();

        $user->save();
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('member');
        $auth->assign($authorRole, $user->getId());
        return $user;
    }
}
