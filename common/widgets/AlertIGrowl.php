<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 27.02.2016
 * Time: 14:54
 */

namespace common\widgets;

use yii\bootstrap\Widget;
use common\widgets\iGrowl\AssetBundle;

/**
 * info, success, notice, error, simple
 * For a more saturated/deeper color style, add the -sat suffix, eg:
 * info-sat, success-sat, notice-sat, error-sat
 */

class AlertIGrowl extends Widget
{
    public function init()
    {
        parent::init();

        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();

        $view = $this->getView();
        AssetBundle::register($view);

        foreach($flashes as $key => $value) {
            \Yii::$app->view->registerJs('
                $.iGrowl({
                    type: "'.$key.'",
                    message: "'.$value.'",
                    offset : {
                        y: 	60
                    }
                });
            ');
            $session->removeFlash($key);
        }
    }
}