<?php

namespace common\widgets\yii2TranslatePanel\models;

use yii\base\InvalidConfigException;
use Yii;
use yii\db\ActiveRecord;
use common\widgets\yii2TranslatePanel\models\query\SourceMessageQuery;
use common\widgets\yii2I18nModule\models\Message;

/**
 * SourceMessage model
 *
 * @property integer    $id
 * @property string     $hash
 * @property string     $category
 * @property string     $message
 * @property string     $location
 */
class SourceMessage extends ActiveRecord
{
    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName()
    {
        $i18n = Yii::$app->getI18n();
        if (!isset($i18n->sourceMessageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }
        return $i18n->sourceMessageTable;
    }

    public static function find()
    {
        return new SourceMessageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['message', 'string'],
            ['translation', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'category'      => Yii::t('app', 'Category'),
            'message'       => Yii::t('app', 'Sourse Messages'),
            'translation'   => Yii::t('app', 'Message Translations'),
            'status'        => Yii::t('app', 'Translation status')
        ];
    }

    /**
     * ActiveRelation
     * @see http://www.yiiframework.com/wiki/621/filter-sort-by-calculated-related-fields-in-gridview-yii-2-0/#hh11
     * @see http://www.ramirezcobos.com/2014/04/16/displaying-sorting-and-filtering-model-relations-on-a-gridview-yii2/
     */
    public function getMessages()
    {
        return $this
            ->hasMany(Message::className(), ['id' => 'id'])
            ->indexBy('language')
        ;
    }

    /**
     * @return array|SourceMessage[]
     */
    public static function getCategories()
    {
        return SourceMessage::find()
            ->select('category')
            ->distinct('category')
            ->asArray()
            ->all()
        ;
    }

    public function initMessages()
    {
        $messages = [];
        foreach (Yii::$app->getI18n()->languages as $language) {
            if (!isset($this->messages[$language])) {
                $message             = new Message;
                $message->language   = $language;
                $messages[$language] = $message;
            } else {
                $messages[$language] = $this->messages[$language];
            }
        }
        $this->populateRelation('messages', $messages);
    }

    public function saveMessages()
    {
        /** @var Message $message */
        foreach ($this->messages as $message) {
            $this->link('messages', $message);
            $message->save();
        }
    }
}
