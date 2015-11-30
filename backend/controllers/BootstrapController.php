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

    public function actionSemantic()
    {
        Yii::$app->request->get();
        return $this->render(
            'semantic',
            [

            ]);
    }

    public function actionAnimate()
    {
        Yii::$app->request->get();
        return $this->render(
            'animate',
            [

            ]);
    }

    public function actionScrollTo()
    {
        return $this->render(
            'scroll-to',
            [

            ]);
    }

    public function actionForm()
    {
        return $this->renderPartial(
            'form-result',
            [
                'name' => Yii::$app->request->post('name')
            ]);
    }
}