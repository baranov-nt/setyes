<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $path
 * @property string $path_small_image
 * @property integer $size
 * @property integer $status
 * @property integer $temp
 *
 * @property ImagesOfObject[] $imagesOfObjects
 * @property UserProfile[] $profiles
 */
class Images extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path_small_image', 'path'], 'required'],
            [['size', 'status', 'temp'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Image ID'),
            'path_small_image' => Yii::t('app', 'Path Small Image'),
            'path' => Yii::t('app', 'Path Image'),
            'size' => Yii::t('app', 'Size Image'),
            'status' => Yii::t('app', 'Status Image'),
            'temp' => Yii::t('app', 'Temp Image'),
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
     * Одна картинка может принадлежать нескольким объектам. Промежуточная таблица images_of_object
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagesOfObjects()
    {
        return $this->hasMany(ImagesOfObject::className(), ['id_image' => 'id']);
    }
}
