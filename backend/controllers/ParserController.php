<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 19.03.2016
 * Time: 12:21
 */

namespace backend\controllers;

use Yii;
use GuzzleHttp\Client;

class ParserController extends BehaviorsController
{
    public function actionIndex() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://yandex.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // вывод страницы Яндекса в представление
        return $this->render('index', ['document' => $body]);
    }
}