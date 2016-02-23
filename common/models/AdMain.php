<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "ad_main".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $place_city_id
 * @property integer $category_id
 * @property integer $ad_style_id
 * @property integer $phone_temp_ad
 *
 *
 * @property AdFavorite[] $adFavorites
 * @property AdCategory $adCategory
 * @property PlaceCity $placeCity
 * @property AdStyle $adStyle
 * @property User $user
 * @property [] $images
 * @property [] $largeImagesList
 * @property [] $smallImagesList
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
            [['user_id', 'place_city_id', 'category_id', 'ad_style_id', 'created_at', 'updated_at'], 'integer'],
            [['phone_temp_ad'], 'string']
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
            'ad_style_id' => Yii::t('app', 'Ad Style'),
            'phone_temp_ad' => Yii::t('app', 'Phone for temp ad'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /* Поведения */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdFavorites()
    {
        return $this->hasMany(AdFavorite::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdFavorite()
    {
        return $this->hasOne(AdFavorite::className(), ['ad_id' => 'id'])
            ->where(['user_id' => Yii::$app->user->id]);
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

    public function getLargeImagesList($images)
    {
        $items = '';

        if(count($images) > 1):
            foreach($images as $one):
                $items[] = [
                    'content' => Html::img('/images/'.$one->image->path, [
                        'style' => 'width: 100%; border-radius: 3px;'
                    ]),
                    'options' => [

                    ],
                    'active' => false
                ];
            endforeach;
        else:
            /* Если одно изоражение */
            foreach($images as $one):
                $items =  Html::img('/images/'.$one->image->path, [
                    'style' => 'width: 100%; border-radius: 3px;'
                ]);
            endforeach;
        endif;

        return $items;
    }

    public function getSmallImagesList($images)
    {
        $items = '';

        if(count($images) > 1):
            foreach($images as $one):
                $items[] = [
                    'content' => Html::img('/images/'.$one->image->path_small_image, [
                        'style' => 'width: 100%; border-radius: 3px;'
                    ]),
                    'options' => [

                    ],
                    'active' => false
                ];
            endforeach;
        else:
            /* Если одно изоражение */
            foreach($images as $one):
                $items =  Html::img('/images/'.$one->image->path_small_image, [
                    'style' => 'width: 100%; border-radius: 3px;'
                ]);
            endforeach;
        endif;

        return $items;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorite($id)
    {
        $modelAdFavorite = AdFavorite::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ]);

        return $modelAdFavorite ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplain($id)
    {
        $modelAdFavorite = AdComplains::findOne([
            'user_id' => Yii::$app->user->id,
            'ad_id' => $id
        ]);

        return $modelAdFavorite ? true : false;
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

    public function getImages($modelAdRealEstate) {
        $items = '';
        foreach($modelAdRealEstate->imagesOfObjects as $one):
            $items[] = [
                'content' => Html::img('/images/'.$one->image->path_small_image, [
                    'style' => 'width: 100%; border-radius: 3px;'
                ]),
                'options' => [

                ],
                'active' => false
            ];
        endforeach;

        return $items;
    }
}
