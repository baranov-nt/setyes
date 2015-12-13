<?php
namespace common\widgets\TimeZone;

use yii\base\Action;

/**
 * Class TimezoneAction
 * @author Dmitry Semenov <disemx@gmail.com>
 * @package yii2mod\timezone
 */
class TimezoneAction extends Action
{
    /**
     * @throws \yii\base\ExitException
     */
    public function run()
    {
        //dd(\Yii::$app->getRequest()->get('timezone', false));
        $timezone = \Yii::$app->getRequest()->post('timezone', false);

        $zoneList = \DateTimeZone::listIdentifiers();

        if (!$timezone || empty($timezone) || !in_array($timezone, $zoneList)) {
            $timezoneAbbr = \Yii::$app->getRequest()->get('timezoneAbbr');
            $timezoneOffset = \Yii::$app->getRequest()->get('timezoneOffset');
            $timezone = timezone_name_from_abbr($timezoneAbbr, $timezoneOffset * 3600);
        }

        if (!$timezone || !in_array($timezone, $zoneList)) {
            $timezone = date_default_timezone_get();
        }

        \Yii::$app->session->set('timezone', $timezone);
        return $this->goBack();
    }
}