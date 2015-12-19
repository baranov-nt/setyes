<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $iso2
 * @property string $short_name
 * @property string $long_name
 * @property string $iso3
 * @property string $numcode
 * @property string $un_member
 * @property string $calling_code
 * @property string $cctld
 * @property integer $phone_number_digits_code
 *
 * @property Place $place
 */
class Country extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_name', 'long_name'], 'required'],
            [['phone_number_digits_code'], 'integer'],
            [['iso2'], 'string', 'max' => 2],
            [['short_name', 'long_name'], 'string', 'max' => 80],
            [['iso3'], 'string', 'max' => 3],
            [['numcode'], 'string', 'max' => 6],
            [['un_member'], 'string', 'max' => 12],
            [['calling_code'], 'string', 'max' => 8],
            [['cctld'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'iso2' => Yii::t('app', 'Iso2'),
            'short_name' => Yii::t('app', 'Short Name'),
            'long_name' => Yii::t('app', 'Long Name'),
            'iso3' => Yii::t('app', 'Iso3'),
            'numcode' => Yii::t('app', 'Numcode'),
            'un_member' => Yii::t('app', 'Un Member'),
            'calling_code' => Yii::t('app', 'Calling Code'),
            'cctld' => Yii::t('app', 'Cctld'),
            'phone_number_digits_code' => Yii::t('app', 'Phone Number Digits Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'id']);
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
