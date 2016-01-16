<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:17
 */

/* @property \common\models\PlaceCountry $modelPlaceCountry */

namespace frontend\models;

use common\models\PlaceCountry;
use Yii;
use yii\base\Model;
use common\rbac\helpers\RbacHelper;
use common\models\User;
use common\models\UserProfile;
use common\models\UserPrivilege;
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
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelPlaceCountry = PlaceCountry::findOne($this->country_id);

        if ($modelPlaceCountry->phone_number_digits_code != strlen($this->phone) && $modelPlaceCountry->phone_number_digits_code != null) {
            $this->addError('phone', Yii::t('app', 'Phone should contain {length, number} digits.', ['length' => $modelPlaceCountry->phone_number_digits_code]));
        }

        if ($modelPlaceCountry->phone_number_digits_code == null) {
            if((strlen($this->phone) < 5) || (strlen($this->phone) > 12)) {
                $this->addError('phone', Yii::t('app', 'Phone is invalid.'));
            }
        }

        if($modelPlaceCountry->iso2 == 'RU') {
            if(substr($this->phone, 0, 1) != '9' && substr($this->phone, 0, 1) != '3') {
                $this->addError('phone', Yii::t('app', 'Phone is invalid.'));
            }
        }

        $phone = $modelPlaceCountry->calling_code.$this->phone;
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
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelUser = User::findOne($id);

        if($this->scenario === 'phoneFinish'):
            $modelUser->phone = $this->getPhoneNumber();
            $modelUser->status = User::STATUS_ACTIVE;
            $modelUser->country_id = $this->country_id;
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        elseif($this->scenario === 'phoneAndEmailFinish'):
            $modelUser->phone = $this->getPhoneNumber();
            $modelUser->email = $this->email;
            $modelUser->country_id = $this->country_id;
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
        $modelUser = new User();
        $modelUser->phone = $this->getPhoneNumber();
        $modelUser->email = $this->email;
        $modelUser->status = $this->status;
        $modelUser->country_id = $this->country_id;
        $modelUser->setPassword($this->password);
        $modelUser->generateAuthKey();

        if($this->scenario === 'emailActivation')
            $modelUser->generateSecretKey();

        if($modelUser->save()):
            $modelUserProfile = new UserProfile();
            $modelUserProfile->link('user', $modelUser);
            $modelUserPrivilege = new UserPrivilege();
            $modelUserPrivilege->link('user', $modelUser);
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        endif;
        return false;
    }

    public function sendActivationEmail($user)
    {
        return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{app_name} (sent a robot).', ['app_name' => Yii::$app->name])])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Activation for {app_name}.', ['app_name' => Yii::$app->name]))
            ->send();
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getCountriesList()
    {
        $modelPlaceCountry = PlaceCountry::find()->asArray()->all();
        $countriesArray = ArrayHelper::map($modelPlaceCountry,
            'id',
            function($modelPlaceCountry) {
                return Yii::t('countries', $modelPlaceCountry['short_name']).' +'.$modelPlaceCountry['calling_code'];
            }
        );

        return $countriesArray;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPhoneNumber()
    {
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelPlaceCountry = PlaceCountry::findOne($this->country_id);
        $phone = $modelPlaceCountry->calling_code.$this->phone;
        $phone = str_replace([' ', '-', '+'], '', $phone);
        return $phone;
    }
}