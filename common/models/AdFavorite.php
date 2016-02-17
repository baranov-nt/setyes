<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_favorite".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ad_id
 *
 * @property AdMain $ad
 * @property User $user
 */
class AdFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_favorite';
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
    public function addToFavorite($id)
    {
        $modelAdFavorite = AdFavorite::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ]);

        if(!$modelAdFavorite) {
            $modelAdFavorite = new AdFavorite();
            $modelAdFavorite->user_id = Yii::$app->user->id;
            $modelAdFavorite->ad_id = $id;
            $modelAdFavorite->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function deleteFromFavorite($id)
    {
        AdFavorite::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ])->delete();
    }
}
