<?php

namespace frontend\modules\ad\controllers;

use frontend\controllers\BehaviorsController;
use common\models\AdMain;

class DefaultController extends BehaviorsController
{
    public function actionIndex()
    {
        $modelAdMain = new AdMain();

        return $this->render('index',
            [
                'modelAdMain' => $modelAdMain
            ]);
    }
}
