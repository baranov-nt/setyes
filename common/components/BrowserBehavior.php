<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 19.02.2016
 * Time: 12:57
 */

namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

class BrowserBehavior  extends Behavior {

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function beforeAction()
    {
        $userAgentInfo = Yii::$app->userAgentParser->getUserAgentObject();
        if($userAgentInfo->browser == 'Opera') {
            if($userAgentInfo->version < 13) {
                \Yii::$app->session->set('browserError', 1);
            }
        }
    }
}