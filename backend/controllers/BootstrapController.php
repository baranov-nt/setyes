<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.11.2015
 * Time: 11:16
 */
namespace backend\controllers;

use Yii;

class BootstrapController extends BehaviorsController
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [

            ]);
    }

    public function actionConfirm()
    {
        Yii::$app->request->get();
        return $this->render(
            'index',
            [

            ]);
    }
}