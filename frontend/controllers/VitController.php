<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 15.03.2016
 * Time: 10:19
 */

namespace frontend\controllers;

use Yii;
use GuzzleHttp\Client;
use frontend\controllers\BehaviorsController;
use yii\helpers\Url;

class VitController extends BehaviorsController
{
    public function actionShowMain() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://kondratiev.net');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // вывод страницы Яндекса в представление
        return $this->render('show-main', ['document' => $body]);
    }

    public function actionYn() {
// создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://www.yandex.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // подключаем phpQuery
        $document = \phpQuery::newDocumentHTML($body);
        // получаем список новостей
        $news = $document->find("ul.b-news-list");
        // выполняем проход циклом по списку
        foreach ($news as $elem) {
            //pq аналог $ в jQuery
            $pq = pq($elem);
            // удалим первую новость в списке
            $pq->find('li.b-news-list__item:first')->remove();
            // выполним поиск в скиске ссылок
            $tags = $pq->find('li.b-news-list__item a');
            // добавим ковычки в начало и в конец предложения
            $tags->append('" ')->prepend(' "'); //
            // добавим свой класс к последней новости списка
            $pq->find('li.b-news-list__item:last')->addClass('my_last_class');
        }
        // вывод списка новостей яндекса с главной страницы в представление
        return $this->render('show-main', ['news' => $news]);
        //return $this->render('show-main', ['document' => $news]);
        //return $this->render('yandexnewslist', ['news' => $news]);
    }

    public function actionShow() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://yandex.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // вывод страницы Яндекса в представление
        return $this->render('show-main', ['document' => $body]);
    }
}