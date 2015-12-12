<?php
namespace common\widgets\Timezone;
use Yii;
use yii\base\Component;
use yii\web\Controller;
use frontend\assets\TimeZoneAsset;

/**
 * Class Timezone
 * @author Dmitry Semenov <disemx@gmail.com>
 * @package yii2mod\timezone
 */
class Timezone extends Component
{
    /**
     * @var string
     */
    public $actionRoute = '/site/timezone';
    /**
     * @var timezone name (ex: Europe/Kiev)
     */
    public $name;
    /**
     * Registering offset-getter if timezone is not set
     */
    public function init()
    {
        //dd($_SERVER);
        //$redirect = $_SERVER['REQUEST_URI'];
        $this->name = \Yii::$app->session->get('timezone');
        //\Yii::$app->session->remove('timezone');

        if ($this->name == null) {
            $this->registerTimezoneScript($this->actionRoute);
            $this->name = date_default_timezone_get();
        }
        Yii::$app->setTimeZone($this->name);
    }
    /**
     * Registering script for timezone detection on before action event
     * @param $actionRoute
     */
    public function registerTimezoneScript($actionRoute)
    {
        \Yii::$app->on(Controller::EVENT_BEFORE_ACTION, function ($event) use ($actionRoute) {
            $view = $event->sender->view;
            TimeZoneAsset::register($view);
        });
    }
}