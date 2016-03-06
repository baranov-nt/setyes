<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "ad_main".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $place_city_id
 * @property integer $category_id
 * @property integer $ad_style_id
 * @property integer $phone_temp_ad
 * @property integer $checked
 * @property integer $temp
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
            [['user_id', 'place_city_id', 'category_id', 'ad_style_id', 'checked', 'temp', 'created_at', 'updated_at'], 'integer'],
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
            'checked' => Yii::t('app', 'Checked'),
            'temp' => Yii::t('app', 'Temp'),
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
    public function getHeader()
    {
        switch ($this->adCategory->category) {
            case 1:
                return $this->adCategory->adRealEstate->dealType->reference_name;
                break;
            case 2:
                break;
        }
        return false;
    }

    public function getAddress() {
        switch ($this->adCategory->category) {
            case 1:
                if ($this->adCategory->adRealEstate->placeAddress) {
                    /* Получает строку адреса */
                    return Yii::$app->placeManager->getAddress($this->adCategory->adRealEstate);
                } else {
                    /* Получает строку города */
                    return Yii::$app->placeManager->getCity($this->adCategory->adRealEstate);
                }
                break;
            case 2:
                break;
        }
        return false;
    }

    public function getAddressMap() {
        switch ($this->adCategory->category) {
            case 1:
                return $this->adCategory->adRealEstate->place_address_id ? true : false;
                break;
            case 2:
                break;
        }
        return false;
    }

    public function getImagesOfObjects() {
        switch ($this->adCategory->category) {
            case 1:
                return $this->adCategory->adRealEstate->imagesOfObjects;
                break;
            case 2:
                break;
        }
        return false;
    }

    public function getContentList() {
        switch ($this->adCategory->category) {
            case 1:
                $modelAdRealEstate = new AdRealEstate();
                $items = '';
                if($this->adCategory->adRealEstate->type_of_property)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('type_of_property').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->typeOfProperty->reference_name).'</p>';
                if($this->adCategory->adRealEstate->area_of_property)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('area_of_property').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->area_of_property).' '.Yii::t('references', $this->adCategory->adRealEstate->measurementOfProperty->reference_name).'</p>';
                if($this->adCategory->adRealEstate->area_of_land)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('area_of_land').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->area_of_land).' '.Yii::t('references', $this->adCategory->adRealEstate->measurementOfLand->reference_name).'</p>';
                if($this->adCategory->adRealEstate->rooms_in_the_apartment)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('rooms_in_the_apartment').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->roomsInTheApartment->reference_name).'</p>';
                if($this->adCategory->adRealEstate->material_housing)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('material_housing').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->materialHousing->reference_name).'</p>';
                if($this->adCategory->adRealEstate->floor)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('floor').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->floor0->reference_name).'</p>';
                if($this->adCategory->adRealEstate->floors_in_the_house)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('floors_in_the_house').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->floorsInTheHouse->reference_name).'</p>';
                if($this->adCategory->adRealEstate->lease_term)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('lease_term').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->leaseTerm->reference_name).'</p>';
                if($this->adCategory->adRealEstate->price)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('price').':</strong> '.
                        Yii::$app->formatter->asCurrency(Yii::t('references', $this->adCategory->adRealEstate->price), $this->adCategory->adRealEstate->user->country->currency)
                        .'</p>';
                if($this->adCategory->adRealEstate->price_for_the_period)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('price_for_the_period').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->priceForThePeriod->reference_name).'</p>';
                if($this->adCategory->adRealEstate->necessary_furniture)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('necessary_furniture').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->necessaryFurniture->reference_name).'</p>';
                if($this->adCategory->adRealEstate->internet)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('internet').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->internet0->reference_name).'</p>';
                if($this->adCategory->adRealEstate->pets_allowed)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('pets_allowed').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->petsAllowed->reference_name).'</p>';
                if($this->adCategory->adRealEstate->adRealEstateAppliances) {
                    $itemsDiv = '';
                    $items .= '<p class="content-elem"><strong>' . $modelAdRealEstate->getAttributeLabel('appliances') . ':</strong> ';
                    foreach ($this->adCategory->adRealEstate->adRealEstateAppliances as $one) {
                        $items .= $itemsDiv . Yii::t('references', $one->reference->reference_name);
                        $itemsDiv = ', ';
                    }
                }
                if($this->adCategory->adRealEstate->condition)
                    $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('condition').':</strong> '.Yii::t('references', $this->adCategory->adRealEstate->condition0->reference_name).'</p>';
                return $items;
                break;
            case 2:
                break;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrlStep1()
    {
        switch ($this->adCategory->category) {
            case 1:
                return Url::to(['/ad/default/index', 'id' => $this->id]);
                break;
            case 2:
                break;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrlStep2()
    {
        switch ($this->adCategory->category) {
            case 1:
                return Url::to(['/ad/real-estate/update', 'id' => $this->adCategory->adRealEstate->id]);
                break;
            case 2:
                break;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrlStep3()
    {
        switch ($this->adCategory->category) {
            case 1:
                return Url::to(['/ad/real-estate/view', 'id' => $this->adCategory->adRealEstate->id]);
                break;
            case 2:
                break;
        }
        return false;
    }

    public function getCity() {
        switch ($this->adCategory->category) {
            case 1:
                return Yii::$app->placeManager->getCity($this->adCategory->adRealEstate);
                break;
            case 2:
                break;
        }
        return false;
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
                        'url' => ['/ad/transport/create'],
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
