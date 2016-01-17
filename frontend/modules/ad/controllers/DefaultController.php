<?php

namespace frontend\modules\ad\controllers;

use frontend\controllers\BehaviorsController;

class DefaultController extends BehaviorsController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
