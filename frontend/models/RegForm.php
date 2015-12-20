<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:17
 */

/* @property \common\models\Country $modelCountry */

namespace frontend\models;

use common\models\Country;
use Yii;
use yii\base\Model;
use common\rbac\helpers\RbacHelper;
use common\models\User;
use common\models\Profile;
use yii\helpers\ArrayHelper;

class RegForm extends Model
{
    public $phone;
    public $email;
    public $password;
    public $status;
    public $location;
    public $password_repeat;
    public $country_id;

    public function rules()
    {
        return [
            [['phone', 'email', 'password'],'filter', 'filter' => 'trim'],
            [['phone', 'email', 'password'],'required', 'on' => 'default'],
            [['phone', 'email', 'password'],'required', 'on' => 'emailActivation'],
            [['phone', 'email', 'country_id'],'required', 'on' => 'phoneAndEmailFinish'],
            [['phone'],'required', 'on' => 'phoneFinish'],
            ['phone', 'validatePhone'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            /*['phone', 'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'This phone is already registered.')],*/
            [['phone'], 'integer'],
            [['country_id'], 'integer'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'This email is already registered.')],
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            ['status', 'in', 'range' =>[
                User::STATUS_NOT_ACTIVE,
                User::STATUS_ACTIVE
            ]],
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => 'emailActivation'],
            ['password_repeat', 'required', 'on' => 'default'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают.", 'on' => 'default'],
        ];
    }

    public function validatePhone()
    {
        /* @var $modelCountry \common\models\Country */
        $modelCountry = Country::findOne($this->country_id);

        if ($modelCountry->phone_number_digits_code != strlen($this->phone)) {
            $this->addError('phone', Yii::t('app', 'Phone should contain {length, number} digits.', ['length' => $modelCountry->phone_number_digits_code]));
        }
        $phone = $modelCountry->calling_code.$this->phone;
        $phone = str_replace([' ', '-', '+'], '', $phone);
        $modelUser = User::findOne(['phone' => $phone]);
        if($modelUser):
            $this->addError('phone', Yii::t('app', 'This phone is already registered.'));
        endif;
    }

    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('app', 'Phone number'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'location' => Yii::t('app', 'City'),
            'country_id' => Yii::t('app', 'Country'),
            'password_repeat' => Yii::t('app', 'Confirm password')
        ];
    }

    public function finishReg($id)
    {
        /* @var $modelUser \common\models\User */
        /* @var $modelCountry \common\models\Country */
        $modelUser = User::findOne($id);
        $modelCountry = Country::findOne($this->country_id);

        if($this->scenario === 'phoneFinish'):
            $phone = $modelCountry->calling_code.$this->phone;
            $phone = str_replace([' ', '-', '+'], '', $phone);
            $modelUser->phone = $phone;
            $modelUser->status = User::STATUS_ACTIVE;
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        elseif($this->scenario === 'phoneAndEmailFinish'):
            $phone = $modelCountry->calling_code.$this->phone;
            $phone = str_replace([' ', '-', '+'], '', $phone);
            $modelUser->phone = $phone;
            $modelUser->email = $this->email;
            $modelUser->setPassword($this->password);
            $modelUser->generateAuthKey();
            $modelUser->generateSecretKey();
            $modelUser->validate();
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        endif;
        return false;
    }

    public function reg()
    {
        /* @var $modelCountry \common\models\Country */
        $modelUser = new User();
        $modelCountry = Country::findOne($this->country_id);
        $phone = $modelCountry->calling_code.$this->phone;
        $phone = str_replace([' ', '-', '+'], '', $phone);
        $modelUser->phone = $phone;
        $modelUser->email = $this->email;
        $modelUser->status = $this->status;
        $modelUser->country_id = $this->country_id;
        $modelUser->setPassword($this->password);
        $modelUser->generateAuthKey();

        if($this->scenario === 'emailActivation')
            $modelUser->generateSecretKey();

        if($modelUser->save()):
            $modelProfile = new Profile();
            $modelProfile->link('user', $modelUser);
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        endif;
        return false;
    }

    public function sendActivationEmail($user)
    {
        return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{app} (sent a robot).')])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Activation for {app}.'))
            ->send();
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getCountriesList()
    {
        $model = Country::find()->asArray()->all();
        $countriesArray = ArrayHelper::map($model,
            'id',
            function($model) {
                return Yii::t('app', $model['short_name']).' +'.$model['calling_code'];
            }
        );

        return $countriesArray;
    }
}