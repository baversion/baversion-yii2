<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\models\Users;

/**
 * Password reset form
 */
class ChangeProfileForm extends Model
{
    public $display_name;
    public $updated_at;
    public $email;
    public $password;

    /**
     * @var \common\models\Users
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param integer $id
     * @throws \yii\base\InvalidParamException if id is empty or not valid
     */
    public function __construct($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('id cannot be blank.');
        }
        $this->_user = Users::findIdentity($id);

        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong id.');
        }

        $this->display_name = $this->_user->display_name;
        $this->email = $this->_user->email;

        parent::__construct([]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['display_name', 'trim'],
            ['display_name', 'required'],
            ['display_name', 'string', 'min' => 2, 'max' => 30],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'قبلا کابری با این ایمیل ثبت‌نام کرده است.'],

            ['password', 'string', 'min' => 6],

            ['image', 'trim'],
            ['image', 'string'],

            ['updated_at', 'integer'],
            ['updated_at', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'آی‌دی',
            'display_name' => ' نام نمایشی',
            'username' => 'یوزرنیم',
            'email' => 'ایمیل',
            'password' => 'پسورد',
            'image' => 'عکس',
            'created_at' => 'تاریخ ثبت نام',
            'updated_at' => 'تاریخ آخرین آپدیت پروفایل'
        ];
    }

    /**
     * Changes profile information.
     *
     * @return bool if password was reset.
     */
    public function changeProfile()
    {
        $user = $this->_user;

        $user->display_name = $this->display_name;
        $user->updated_at = time();

        if (!empty($this->password))
        {
            $user->setPassword($this->password);
        }

        if ($user->email !== $this->email)
        {
            $user->email = $this->email;
            $user->generateEmailAuthKey();
        }

        return $user->save(false);
    }
}
