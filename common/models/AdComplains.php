<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_complains".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ad_id
 *
 * @property AdMain $ad
 * @property User $user
 */
class AdComplains extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_complains';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ad_id'], 'required'],
            [['user_id', 'ad_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(AdMain::className(), ['id' => 'ad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function addToComplains($id)
    {
        $modelAdComplain = AdComplains::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ]);

        if(!$modelAdComplain) {
            $modelAdComplain = new AdComplains();
            $modelAdComplain->user_id = Yii::$app->user->id;
            $modelAdComplain->ad_id = $id;
            $modelAdComplain->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function deleteFromComplains($id)
    {
        AdComplains::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ])->delete();
    }
}
