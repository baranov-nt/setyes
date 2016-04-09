<?php

namespace backend\modules\node\controllers;

use backend\controllers\BehaviorsController;

class TestController extends BehaviorsController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
