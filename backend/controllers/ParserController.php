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
use yii\web\Controller;

class ParserController extends Controller
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

    public function actionYaNews() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://www.yandex.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // подключаем phpQuery
        $document = \phpQuery::newDocumentHTML($body);
        //Смотрим html страницы Яндекса, определяем внешний класс списка и считываем его командой find
        $news = $document->find(".b-news-list");
        //d(count($news));
        // вывод списка новостей Яндекса с главной страницы в представление
        return $this->render('ya-news', ['news' => $news]);
    }

    public function actionYaNewsList() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://www.yandex.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // подключаем phpQuery
        $document = \phpQuery::newDocumentHTML($body);
        // получаем список новостей
        //$news = $document->find("ul.b-news-list");
        $news = $document->find(".b-news-list");
        //d(count($news));
        // выполняем проход циклом по списку
        foreach ($news as $elem) {
            //pq аналог $ в jQuery
            $pq = pq($elem);
            // удалим первую новость в списке
            $pq->find('li.list__item:first')->remove();
            // выполним поиск в скиске ссылок
            $tags = $pq->find('li.list__item a');
            // добавим ковычки в начало и в конец предложения
            $tags->append('" ')->prepend(' "'); //
            // добавим свой класс к последней новости списка
            $pq->find('li.list__item:last')->addClass('my_last_class');
        }
        // вывод списка новостей яндекса с главной страницы в представление
        return $this->render('ya-news-list', ['news' => $news]);
    }

    public function actionKNet() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://kondratiev.net/loader.php?getPage=gallery');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // подключаем phpQuery
        $document = \phpQuery::newDocumentHTML($body);
        // получаем список новостей
        //$news = $document->find("ul.b-news-list");
        $kSite = $document->find(".widePhotoGallery");
        //d(count($kSite));
        // выполняем проход циклом по списку
        foreach ($kSite as $elem) {
            //pq аналог $ в jQuery
            $pq = pq($elem);
            // удалим первую новость в списке
            //$pq->find('li.list__item:first')->remove();
            // выполним поиск в скиске ссылок
            //$tags = $pq->find('li.list__item a');
            // добавим ковычки в начало и в конец предложения
            //$tags->append('" ')->prepend(' "'); //
            // добавим свой класс к последней новости списка
            $pq->find('div.widePhoto')->addClass('display-block');
        }
        // вывод списка новостей яндекса с главной страницы в представление
        return $this->render('k-net', ['kSite' => $kSite]);
    }
}