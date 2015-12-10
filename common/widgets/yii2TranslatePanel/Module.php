<?php

namespace common\widgets\yii2TranslatePanel;

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
        return Yii::t('app', $message, $params, $language);
    }
}
