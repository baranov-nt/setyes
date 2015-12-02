<?php

namespace common\widgets\Translate;

use Yii;

class Module extends \yii\base\Module
{
    public $pageSize = 25;

    public static function module()
    {
        return static::getInstance();
    }

    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('yii', $message, $params, $language);
    }
}