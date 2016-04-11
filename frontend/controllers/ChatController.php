<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2016
 * Time: 18:01
 */

namespace frontend\controllers;

use yii\helpers\Json;
use frontend\models\ChatForm;

class ChatController extends BehaviorsController
{
    public function actionIndex()
    {
        $modelChatForm = new ChatForm();

        if ($modelChatForm->load(\Yii::$app->request->post())) {
            \Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'notification',
                'message' => Json::encode(['name' => $modelChatForm->name, 'message' => $modelChatForm->message])
            ]);
            $modelChatForm->message = '';
        }

        return $this->render('index',
            [
                'modelChatForm' => $modelChatForm
            ]);
    }

    public function actionVer2()
    {
        $modelChatForm = new ChatForm();

        if ($modelChatForm->load(\Yii::$app->request->post())) {
            \Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'notification',
                'message' => Json::encode(['name' => $modelChatForm->name, 'message' => $modelChatForm->message, 'time' => \Yii::$app->formatter->asDatetime(time(), 'medium')])
            ]);
            $modelChatForm->message = '';
        }

        return $this->render('ver2',
            [
                'modelChatForm' => $modelChatForm
            ]);
    }
}