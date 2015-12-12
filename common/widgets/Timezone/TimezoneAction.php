<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 12.12.2015
 * Time: 16:08
 */

namespace common\widgets\Timezone;

use yii\base\Action;
use Yii;
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
        //dd(Yii::$app->getRequest()->post());
        $timezone = \Yii::$app->getRequest()->get('timezone', false);
        //dd($timezone);
        $zoneList = \DateTimeZone::listIdentifiers();
        if (!$timezone || empty($timezone) || !in_array($timezone, $zoneList)) {
            $timezoneAbbr = \Yii::$app->getRequest()->get('timezoneAbbr');
            $timezoneOffset = \Yii::$app->getRequest()->get('timezoneOffset');
            $timezone = timezone_name_from_abbr($timezoneAbbr, $timezoneOffset * 3600);
            //dd($timezone);
        }
        if (!$timezone || !in_array($timezone, $zoneList)) {
            $timezone = date_default_timezone_get();
        }
        \Yii::$app->timeZone = $timezone;
        //dd($timezone);
        \Yii::$app->session->set('timezone', $timezone);
        \Yii::$app->end();
    }
}