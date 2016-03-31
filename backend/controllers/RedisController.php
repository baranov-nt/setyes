<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 31.03.2016
 * Time: 20:40
 */

namespace backend\controllers;

//use backend\models\RedisModel;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use Redis;

class RedisController extends Controller
{
    public function actionIndex() {
        return Yii::$app->redis->executeCommand('PUBLISH', [
            'channel' => 'notification',
            'message' => Json::encode(['name' => 'asdasdasd', 'message' => 'ffffffffff'])
        ]);
        /*$modelRedisModel = new RedisModel();
        $modelRedisModel->name = 'Test';
        $modelRedisModel->address = 'Test';
        $modelRedisModel->registration_date = 'Test';
        $modelRedisModel->save();
        echo $modelRedisModel->id; // id will automatically be incremented if not set explicitly*/

        /*$query1 = RedisModel::find()->where(['name' => 'test'])->one(); // find by query
        $query2 = RedisModel::find()->active()->all(); // find all by query (using the `active` scope)*/

        return $this->render('index', [
            /*'query1' => $query1,
            'query2' => $query2*/
        ]);
    }
}