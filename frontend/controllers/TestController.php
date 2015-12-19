<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.12.2015
 * Time: 9:04
 */
namespace frontend\controllers;

use common\models\Country;

class TestController extends BehaviorsController
{
    public function actionIndex()
    {
        $modelCountry = new Country();

        return $this->render(
            'index',
            [
                'modelCountry' => $modelCountry
            ]
            );
    }
}
