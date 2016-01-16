<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "images_of_object".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $object_id
 * @property string $label
 * @property integer $place
 *
 * @property Carousel $object
 * @property Images $image
 * @property UserProfile $object1
 */
class ImagesOfObject extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_of_object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'object_id', 'place'], 'integer'],
            [['label'], 'string', 'max' => 32]
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject1()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'object_id']);
    }
}
