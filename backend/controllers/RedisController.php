<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 31.03.2016
 * Time: 20:40
 */

namespace backend\controllers;

use backend\models\RedisModel;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use Redis;

class RedisController extends Controller
{
    public function actionIndex() {
        /*return Yii::$app->redis->executeCommand('PUBLISH', [
            'channel' => 'notification',
            'message' => Json::encode(['name' => 'asdasdasd', 'message' => 'ffffffffff'])
        ]);*/
        $modelRedisModel = new RedisModel();
        $modelRedisModel->name = 'Test name';
        $modelRedisModel->address = 'Test addres';
        $modelRedisModel->registration_date = 'Test date';
        $modelRedisModel->save();
        //echo $modelRedisModel->id; // id will automatically be incremented if not set explicitly

        Yii::$app->cache->set('cacheElem', '30 second', 30); // срок жизни в кэше 30 секунд
        Yii::$app->session->set('sessionElem', '30 second'); // срок жизни в сессии в конфиге (30 секунд)

        //$query1 = RedisModel::find()->where(['phone' => '79221301879'])->one(); // find by query
        $query2 = RedisModel::find()->all(); // find all by query (using the `active` scope)

        return $this->render('index', [
            'query1' => $query2,
            //'query2' => $query2
        ]);
    }
}