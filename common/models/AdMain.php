<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ad_main".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $place_city_id
 * @property integer $category_id
 * @property integer $ad_style_id
 *
 * @property AdCategory $adCategory
 * @property PlaceCity $placeCity
 * @property AdStyle $adStyle
 * @property User $user
 */
class AdMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'required'],
            [['user_id', 'place_city_id', 'category_id', 'ad_style_id'], 'integer']
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
            'place_city_id' => Yii::t('app', 'Place City ID'),
            'category_id' => Yii::t('app', 'Ad Category ID'),
            'ad_style_id' => Yii::t('app', 'Ad Style ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategory()
    {
        return $this->hasOne(AdCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceCity()
    {
        return $this->hasOne(PlaceCity::className(), ['id' => 'place_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdStyle()
    {
        return $this->hasOne(AdStyle::className(), ['id' => 'ad_style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Получить id создателя объявления
     * NOTE: needed for RBAC Author rule.
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->user_id;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getMainCategoryList()
    {
        $mainCategory = ArrayHelper::map(AdMainReference::find()
            ->where(['reference_id' => 1])
            ->all(), 'id', 'reference_name');

        $items = [];
        foreach($mainCategory as $key => $value):
            switch ($key) {
                case 1:     // Недвижемость
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create'],
                    ];
                    break;
                case 2:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
                case 3:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
                case 4:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
                case 5:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
                case 6:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
                case 7:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/#'],
                    ];
                    break;
            }
        endforeach;

        return $items;
    }
}
