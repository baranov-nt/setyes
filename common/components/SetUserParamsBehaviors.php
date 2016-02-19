<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.11.2015
 * Time: 9:33
 */

namespace common\components;

use Yii;
use yii\web\View;
use yii\base\Behavior;

class SetUserParamsBehaviors extends Behavior
{
    public $view;

    public function init()
    {
        parent::init();
        if(\Yii::$app->session->get('browserError') == 1) {
            throw new \yii\web\MethodNotAllowedHttpException(Yii::t('app', 'You are not dddallowed to access this page.'));
        }
    }

    public function events()
    {
        return [
            View::EVENT_BEGIN_PAGE => 'beforeBeginPage'
        ];
    }

    public function beforeBeginPage()
    {
        //Yii::$app->timeZone = Yii::$app->timezone->name;
    }
}