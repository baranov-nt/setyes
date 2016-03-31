<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.03.2016
 * Time: 20:14
 */

namespace backend\controllers;

use common\models\UserProfile;
use Yii;
use yii\web\Controller;

class PjaxController extends Controller
{
    public function actionIndex() {
        return $this->render('index', [
            'time' => date('H:i:s')
        ]);
    }

    public function actionGetTime() {
        return $this->render('index', [
            'time' => date('H:i:s')
        ]);
    }

    public function actionShowMiddleName() {
        $modelProfile = UserProfile::findOne([
            'user_id' => Yii::$app->user->id
        ]);

        return $this->render('index', [
            'modelProfile' => $modelProfile
        ]);
    }

    public function actionUpdateMiddleName() {
        /* @var $modelProfile \common\models\UserProfile */
        $modelProfile = UserProfile::findOne([
            'user_id' => Yii::$app->user->id
        ]);

        $modelProfile->load(Yii::$app->request->post());

        $modelProfile->save();

        return $this->render('index', [
            'middleName' => $modelProfile->middle_name
        ]);
    }

    public function actionDeleteMiddleName() {
        /* @var $modelProfile \common\models\UserProfile */
        $modelProfile = UserProfile::findOne([
            'user_id' => Yii::$app->user->id
        ]);

        $modelProfile->middle_name = '';

        $modelProfile->save();

        return $this->render('index', [
            'middleName' => $modelProfile->middle_name
        ]);
    }
}