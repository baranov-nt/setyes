<?php

namespace frontend\modules\ad\controllers;

use Yii;
use frontend\controllers\BehaviorsController;
use common\models\AdMain;
use common\models\AdRealEstate;
use yii\web\MethodNotAllowedHttpException;

class DefaultController extends BehaviorsController
{
    public function actionIndex($id = null)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        if($id) {
            if (Yii::$app->user->can('Автор', ['model' => $modelAdRealEstate->adCategory->adMain])) {
                $modelAdRealEstate = AdRealEstate::findOne($id);
                if($modelAdRealEstate) {
                    $modelAdRealEstate->deleteObject($modelAdRealEstate);
                }
            } else {
                throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
            }
        }

        $modelAdMain = new AdMain();

        return $this->render('index',
            [
                'modelAdMain' => $modelAdMain
            ]);
    }
}
