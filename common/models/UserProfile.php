<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property integer $images_num
 * @property string $images_label
 * @property string $first_name
 * @property string $second_name
 * @property string $middle_name
 * @property integer $the_second_phone
 * @property integer $the_third_phone
 * @property integer $birthday
 * @property integer $gender
 *
 * @property ImagesOfObject[] $imagesOfObjects
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['images_num', 'the_second_phone', 'the_third_phone', 'birthday', 'gender'], 'integer'],
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
            'first_name' => Yii::t('app', 'First Name'),
            'second_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'the_second_phone' => Yii::t('app', 'The Second Phone'),
            'the_third_phone' => Yii::t('app', 'The Third Phone'),
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
        $modelUserProfile = ($modelUserProfile = UserProfile::findOne(Yii::$app->user->id)) ? $modelUserProfile : new UserProfile();
        $modelUserProfile->user_id = Yii::$app->user->id;
        $modelUserProfile->first_name = $this->first_name;
        $modelUserProfile->second_name = $this->second_name;
        $modelUserProfile->middle_name = $this->middle_name;
        if($modelUserProfile->save()):
            return $modelUserProfile;
        endif;
        return false;
    }
}
