<?php

namespace frontend\modules\ad\controllers;

use Yii;
use frontend\controllers\BehaviorsController;
use common\models\AdMain;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

class DefaultController extends BehaviorsController
{
    public function actionIndex($id = null)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        if($id) {
            $modelAdMain = $this->findModel($id);
            if (Yii::$app->user->can('Автор', ['model' => $modelAdMain])) {
                if($modelAdMain->adCategory->adRealEstate) {
                    $modelAdMain->adCategory->adRealEstate->deleteObject($modelAdMain->adCategory->adRealEstate);
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

    /**
     * Finds the AdMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
