<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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
            'reputation' => 'اعتبار',
            'image' => 'عکس',
            'rememberMe' => 'مرا بخاطر داشته باش',
            'created_at' => 'تاریخ ثبت نام',
            'updated_at' => 'تاریخ آخرین آپدیت پروفایل',
            'last_login' => 'تاریخ آخرین لاگین',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'ایمیل یا پسورد اشتباه است.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUserByUsername()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }


}
