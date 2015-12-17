<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:16
 */
namespace common\models;

use yii\base\Model;
use Yii;

class LoginForm extends Model
{
    public $phone;
    public $password;
    public $email;
    public $rememberMe = true;
    public $status;
    public $reCaptcha;

    private $_user = false;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required', 'on' => 'default'],
            [['phone'], 'integer'],
            [['email', 'password'], 'required', 'on' => 'loginWithEmail'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LcWAxMTAAAAAEZCbXGi-azhHhA8kYRq5WmY9pLg',
                'on' => 'loginWithCaptcha' //your secret key
            ]
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()):
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)):
                $field = ($this->scenario === 'loginWithEmail') ? Yii::t('app', 'email') : Yii::t('app', 'phone');
                $this->addError($attribute, Yii::t('app', 'Wrong {field} or password.', ['field' => $field]));
            endif;
        endif;
    }

    public function getUser()
    {
        if ($this->_user === false):
            if($this->scenario === 'loginWithEmail'):
                $this->_user = User::findByEmail($this->email);
            else:
                $this->_user = User::findByphone($this->phone);
            endif;
        endif;
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('app', 'Phone number'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
            'reCaptcha' => Yii::t('app', 'Captha')
        ];
    }

    public function login()
    {
        /* @var $user User */
        if ($this->validate()):
            $this->status = ($user = $this->getUser()) ? $user->status : User::STATUS_NOT_ACTIVE;
            if ($this->status === User::STATUS_ACTIVE):
                return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }
}