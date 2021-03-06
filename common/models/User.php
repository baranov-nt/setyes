<?php

namespace common\models;

use common\rbac\models\AuthItem;
use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\rbac\models\Role;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $phone
 * @property string $email
 * @property string $balance
 * @property string $password_hash
 * @property integer $status
 * @property integer $country_id
 * @property string $auth_key
 * @property string $secret_key
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AdComplains[] $adComplains
 * @property AdFavorite[] $adFavorites
 * @property AdMain[] $adMains
 * @property Auth[] $auths
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property PlaceCountry $country
 * @property UserPrivilege $userPrivilege
 * @property UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;

    public $password;
    public $case_1;
    public $case_2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @var \common\rbac\models\Role
     */
    public $item_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'auth_key'], 'required'],
            [['balance'], 'number'],
            [['status', 'country_id', 'created_at', 'updated_at'], 'integer'],
            [['phone', 'auth_key'], 'string', 'max' => 32],
            [['email', 'password_hash', 'secret_key'], 'string', 'max' => 255],
            ['phone', 'unique', 'message' => Yii::t('app', 'This phone is already registered.')],
            ['email', 'unique', 'message' => Yii::t('app', 'This email is already registered.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'User ID'),
            'phone' => Yii::t('app', 'Phone number'),
            'phone_second' => Yii::t('app', 'Additional phone number'),
            'email' => Yii::t('app', 'Email'),
            'balance' => Yii::t('app', 'Balance'),
            'country_id' => Yii::t('app', 'Country ID'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
            'auth_key' => 'Auth Key',
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'item_name' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasOne(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(PlaceCountry::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrivilege()
    {
        return $this->hasOne(UserPrivilege::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /* Поведения */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /* Поиск */

    /** Находит пользователя по имени и возвращает объект найденного пользователя.
     *  Вызываеться из модели LoginForm.
     *
     * @param $phone
     * @return null|static
     */
    public static function findByphone($phone)
    {
        $phone = str_replace([' ', '-', '+'], '', $phone);

        $user = static::findOne([
            'phone' => $phone
        ]);

        if($user) {
            return $user;
        }

        if(substr($phone, 0, 1) == '8' && strlen($phone) == 11) {
            $phone = substr_replace($phone, '7', 0, 1);
            $user = static::findOne([
                'phone' => $phone
            ]);
        }
        return $user;
    }

    /* Находит пользователя по емайл */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email
        ]);
    }

    public static function findBySecretKey($key)
    {
        if (!static::isSecretKeyExpire($key))
        {
            return null;
        }
        return static::findOne([
            'secret_key' => $key,
        ]);
    }

    /* Хелперы */
    public function generateSecretKey()
    {
        $this->secret_key = Yii::$app->security->generateRandomString().'_'.time();
    }

    public function removeSecretKey()
    {
        $this->secret_key = null;
    }

    public static function isSecretKeyExpire($key)
    {
        if (empty($key))
        {
            return false;
        }
        $expire = Yii::$app->params['secretKeyExpire'];
        $parts = explode('_', $key);
        $timestamp = (int) end($parts);

        return $timestamp + $expire >= time();
    }

    /**
     * Генерирует хеш из введенного пароля и присваивает (при записи) полученное значение полю password_hash таблицы user для
     * нового пользователя.
     * Вызываеться из модели RegForm.
     * @param $password
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирует случайную строку из 32 шестнадцатеричных символов и присваивает (при записи) полученное значение полю auth_key
     * таблицы user для нового пользователя.
     * Вызываеться из модели RegForm.
     */
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Сравнивает полученный пароль с паролем в поле password_hash, для текущего пользователя, в таблице user.
     * Вызываеться из модели LoginForm.
     * @param $password
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /* Аутентификация пользователей */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function updateUser()
    {
        $user = User::findOne(Yii::$app->user->id);
        $phone = $this->phone;
        $user->phone = $phone;
        if($user->save()):
            return $user;
        else:
            return false;
        endif;
    }

    /* Хелперы */

    /**
     * Returns the user status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_DELETED)
        {
            return Yii::t('app', "Ban");
        }
        elseif ($status === self::STATUS_NOT_ACTIVE)
        {
            return Yii::t('app', "Not activated");
        }
        else
        {
            return Yii::t('app', "Activated");
        }
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_ACTIVE     => Yii::t('app', "Activated"),
            self::STATUS_NOT_ACTIVE => Yii::t('app', "Not activated"),
            self::STATUS_DELETED    => Yii::t('app', "Ban")
        ];
        return $statusArray;
    }


    /**
     * Связь с Role моделью.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasMany(Role::className(), ['user_id' => 'id']);
    }

    /**
     * Возвращает название роли ( item_name )
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->role->item_name;
    }
}
