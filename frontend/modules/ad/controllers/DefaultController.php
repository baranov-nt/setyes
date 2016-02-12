<?php

namespace frontend\modules\ad\controllers;

use frontend\controllers\BehaviorsController;
use common\models\AdMain;
use common\models\AdRealEstate;

class DefaultController extends BehaviorsController
{
    public function actionIndex($id = null)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        if($id) {
            $modelAdRealEstate = AdRealEstate::findOne($id);
            if($modelAdRealEstate) {
                $modelAdRealEstate->deleteObject($modelAdRealEstate);
            }
        }

        $modelAdMain = new AdMain();

        return $this->render('index',
            [
                'modelAdMain' => $modelAdMain
            ]);
    }
}
