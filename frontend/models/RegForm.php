<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:17
 */
namespace frontend\models;

use common\models\Country;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use common\rbac\helpers\RbacHelper;
use common\models\User;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;

class RegForm extends Model
{
    public $phone;
    public $email;
    public $password;
    public $status;
    public $location;
    public $country;
    public $password_repeat;

    public function rules()
    {
        return [
            [['phone', 'email', 'password'],'filter', 'filter' => 'trim'],
            [['phone', 'email', 'password'],'required', 'on' => 'default'],
            [['phone', 'email', 'password'],'required', 'on' => 'emailActivation'],
            [['phone', 'email', 'country'],'required', 'on' => 'phoneAndEmailFinish'],
            [['phone'],'required', 'on' => 'phoneFinish'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['phone', 'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'This phone is already registered.')],
            [['phone'], 'integer'],
            [['phone'], 'integer'],
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

    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('app', 'Phone number'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'location' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Country'),
            'password_repeat' => Yii::t('app', 'Confirm password')
        ];
    }

    public function finishReg($id)
    {
        /* @var $modelUser \common\models\User */
        
        $modelUser = User::findOne($id);

        if($this->scenario === 'phoneFinish'):
            $modelUser->phone = $this->phone;
            $modelUser->status = User::STATUS_ACTIVE;
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        elseif($this->scenario === 'phoneAndEmailFinish'):
            $modelUser->phone = $this->phone;
            $modelUser->email = $this->email;
            $modelUser->setPassword($this->password);
            $modelUser->generateAuthKey();
            $modelUser->generateSecretKey();
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        endif;
        return false;
    }

    public function reg()
    {
        dd(Yii::$app->request->post());
        $user = new User();
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($this->scenario === 'emailActivation')
            $user->generateSecretKey();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($user->save()):
                $modelProfile = new Profile();
                $modelProfile->user_id = $user->id;
                if($modelProfile->save()):
                    $transaction->commit();
                    return RbacHelper::assignRole($user->getId()) ? $user : null;
                endif;
            else:
                return false;
            endif;
        } catch (Exception $e) {
            $transaction->rollBack();
        }

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
            'iso2',
            function($model, $defaultValue) {
                return Yii::t('app', $model['short_name']).' +'.$model['calling_code'];
            }
        );

        return $countriesArray;
    }
}