<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.03.2016
 * Time: 21:58
 */

namespace common\widgets\PjaxWidgetForm;

use Yii;
use yii\base\Widget;
use common\models\UserProfile;

class PjaxWidgetForm extends Widget
{
    public $modelProfile = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        /* @var $modelProfile \common\models\UserProfile */
        $modelProfile = UserProfile::findOne([
            'user_id' => Yii::$app->user->id
        ]);

        if($this->modelProfile) {
            return $this->render('view', [
                'modelProfile' => $this->modelProfile
            ]);
        }
        return $this->render('view', [
            'middleName' => $modelProfile->middle_name
        ]);
    }
}