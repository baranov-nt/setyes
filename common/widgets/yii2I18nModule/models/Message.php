<?php

namespace common\widgets\yii2I18nModule\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use common\widgets\yii2I18nModule\Module;

class Message extends ActiveRecord
{
    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName()
    {
        $i18n = Yii::$app->getI18n();
        if (!isset($i18n->messageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }
        return $i18n->messageTable;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['language', 'required'],
            ['language', 'string', 'max' => 16],
            ['translation', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'language' => Module::t('Language'),
            'translation' => Module::t('Translation')
        ];
    }

    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
}
