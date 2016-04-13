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
use yii\helpers\Html;

class ChatController extends BehaviorsController
{
    public function actionIndex()
    {
        $modelChatForm = new ChatForm();

        if ($modelChatForm->load(\Yii::$app->request->post())) {
            //dd($modelChatForm);
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
            \Yii::$app->redis->executeCommand('PUBLISH',
                [
                    'channel' => 'notification',
                    'message' => Json::encode(
                        [
                            'name' => Html::encode($modelChatForm->name),
                            'message' => Html::encode($modelChatForm->message),
                            'time' => \Yii::$app->formatter->asDatetime(time(),'medium'),
                            'active' => $modelChatForm->active
                        ])]);
            $modelChatForm->message = '';
        }

        return $this->render('ver2',
            [
                'modelChatForm' => $modelChatForm
            ]);
    }

    public function actionVideo()
    {
        /*$modelChatForm = new ChatForm();

        if ($modelChatForm->load(\Yii::$app->request->post())) {
            \Yii::$app->redis->executeCommand('PUBLISH',
                [
                    'channel' => 'notification',
                    'message' => Json::encode(
                        [
                            'name' => Html::encode($modelChatForm->name),
                            'message' => Html::encode($modelChatForm->message),
                            'time' => \Yii::$app->formatter->asDatetime(time(),'medium'),
                            'active' => $modelChatForm->active
                        ])]);
            $modelChatForm->message = '';
        }*/

        return $this->render('video',
            [
                //'modelChatForm' => $modelChatForm
            ]);
    }
}