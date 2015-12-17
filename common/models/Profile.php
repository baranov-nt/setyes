<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property integer $images_num
 * @property string $images_label
 * @property string $first_name
 * @property string $second_name
 * @property string $middle_name
 * @property integer $phone_second
 * @property integer $phone_third
 * @property integer $birthday
 * @property integer $gender
 *
 * @property ImagesOfObject[] $imagesOfObjects
 * @property User $user
 */

class Profile extends ActiveRecord
{
    public $case_3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['images_num', 'birthday', 'gender', 'phone_second', 'phone_third'], 'integer'],
            [['images_label', 'first_name', 'second_name', 'middle_name'], 'string', 'max' => 32]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'images_num' => Yii::t('app', 'Images Num'),
            'images_label' => Yii::t('app', 'Images Label'),
            'avatar' => Yii::t('app', 'Avatar'),
            'first_name' => Yii::t('app', 'First Name'),
            'second_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'birthday' => Yii::t('app', 'Birthday'),
            'gender' => Yii::t('app', 'Gender'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Один пользователь может иметь много аватарок. Промежуточная таблица images_of_object
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagesOfObjects()
    {
        return $this->hasMany(ImagesOfObject::className(),
            [
                'object_id' => 'user_id',
                'label' => 'images_label'
            ]);
    }

    // Связь напрямую к картинкам
    // получить данные много ко многим через модель см getImages() которая использует getImagesOfObjects() в данной модели Profile
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['id' => 'object_id'])
            ->via('imagesOfObjects');
    }

    public function updateProfile()
    {
        $profile = ($profile = Profile::findOne(Yii::$app->user->id)) ? $profile : new Profile();
        $profile->user_id = Yii::$app->user->id;
        $profile->first_name = $this->first_name;
        $profile->second_name = $this->second_name;
        $profile->middle_name = $this->middle_name;
        if($profile->save()):
            return $profile;
        endif;
        return false;
    }
}
