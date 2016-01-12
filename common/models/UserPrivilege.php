<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_privilege".
 *
 * @property integer $user_id
 * @property integer $premium
 * @property integer $images_num
 * @property integer $phones
 * @property integer $vip_style
 * @property integer $time_privilege
 *
 * @property User $user
 */
class UserPrivilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_privilege';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['premium', 'images_num', 'phones', 'vip_style', 'time_privilege'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'premium' => Yii::t('app', 'Premium'),
            'images_num' => Yii::t('app', 'Images Num'),
            'phones' => Yii::t('app', 'Phones'),
            'vip_style' => Yii::t('app', 'Vip Style'),
            'time_privilege' => Yii::t('app', 'Time Privilege'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
