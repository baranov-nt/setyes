<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2016
 * Time: 18:01
 */

namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\Json;

class ChatController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->request->post()) {

            $name = \Yii::$app->request->post('name');
            $message = \Yii::$app->request->post('message');

            return \Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'notification',
                'message' => Json::encode(['name' => $name, 'message' => $message])
            ]);

        }

        return $this->render('index');
    }
}