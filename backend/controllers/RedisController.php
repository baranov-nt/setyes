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
        /*$modelRedisModel = new RedisModel();
        $modelRedisModel->name = 'Test name';
        $modelRedisModel->address = 'Test addres';
        $modelRedisModel->registration_date = 'Test date';
        $modelRedisModel->save();*/
        //echo $modelRedisModel->id; // id will automatically be incremented if not set explicitly

        /* ------------------------------------------------------------------------------------------------------- */
        /*                                        Шпаргалка по Redis                                               */
        /*                                 https://habrahabr.ru/post/204354/                                       */
        /* ------------------------------------------------------------------------------------------------------- */

        /* очистка базы данных от всех элементов в одной базе данных */
        Yii::$app->redis->executeCommand('FLUSHDB');
        /* очистка базы данных от всех элементов во всех базах данных */
        Yii::$app->redis->executeCommand('FLUSHALL');

        /**
         *  Задача 1, создание, выборка, модификация, удаление и базовая информация об объектах.
         *  Установить и прочитать значения с ключами вида test:1:*. Узнать тип значения, проверить
         *  существование элемента, извлечь все поля записи test:1, удалить поле записи test:1.
         */

        /* добавление элемента */
        Yii::$app->redis->executeCommand('SET', ['folder:test:key1', 'Тестовая строка']);
        Yii::$app->redis->executeCommand('SET', ['folder:test:key2', 'Удалится через 60 секунд']);
        Yii::$app->redis->executeCommand('SET', ['folder:test:key3', 'Строка будет удалена']);
        /* извлечение элемента */
        $key = Yii::$app->redis->executeCommand('GET', ['folder:test:key1']);
        /* изменение элемента */
        Yii::$app->redis->executeCommand('GETSET', ['folder:test:key1', 'Новая тестовая строка']);
        /* переименование элемента */
        Yii::$app->redis->executeCommand('RENAME', ['folder:test:key1', 'folder:test:key1_newName']);
        /* переименование элемента обратно */
        Yii::$app->redis->executeCommand('RENAME', ['folder:test:key1_newName', 'folder:test:key1']);
        /* проверка существования элемента (возвращает: 1 - есть, 0 - нет) */
        $existKey1 = Yii::$app->redis->executeCommand('EXISTS', ['folder:test:key1']);
        /* получить все ключи в folder:test:* */
        $keys = Yii::$app->redis->executeCommand('KEYS', ['folder:test:*']);
        /* удаление ключа (возвращает: 1 - да, 0 - нет) */
        Yii::$app->redis->executeCommand('DEL', ['folder:test:key3']);

        d([
            'Задача 1',
            $key,
            $existKey1,
            $keys,
        ]);

        /**
         *  Задача 2, время жизни объекта.
         */

        /* проверка времени жизни элемента (возвращает -1, если бесконечно, или значение секунд, оставшееся до удаления) */
        $expire1 = Yii::$app->redis->executeCommand('TTL',['folder:test:key2']);
        /* установка времени жизни элемента в секундах (возращает 1, если успешно) */
        $setExpire = Yii::$app->redis->executeCommand('EXPIRE',['folder:test:key2', 60]);
        $expire2 = Yii::$app->redis->executeCommand('TTL',['folder:test:key2']);

        d([
            'Задача 2',
            $expire1,
            $setExpire,
            $expire2,
        ]);

        /**
         *  Задача 3, транзакции.
         * Для реализации транзакций в Redis используются следующие основные команды:
         * MULTI — начать запись команд для транзакции.
         * EXEC — выполнить записанные команды.
         * DISCARD — удалить все записанные команды.
         * WATCH — команда, обеспечивающая поведение типа «check-and-set» (CAS) — транзакция выполняется только в случае,
         * если другие клиенты не изменили значение переменной. Иначе EXEC не выполнит записанные команды.
         */

        Yii::$app->redis->executeCommand('MULTI');
        Yii::$app->redis->executeCommand('SET', ['folder:test:key4', 1]);
        /* прибавить на 1 */
        Yii::$app->redis->executeCommand('INCR', ['folder:test:key4']);
        Yii::$app->redis->executeCommand('INCR', ['folder:test:key4']);
        //$valueKey4_1 = Yii::$app->redis->executeCommand('GET', ['folder:test:key4']);
        /* уменьшить на 1 */
        Yii::$app->redis->executeCommand('DECR', ['folder:test:key4']);
        //$valueKey4_2 = Yii::$app->redis->executeCommand('GET', ['folder:test:key4']);
        /* Выполнить транзакцию */
        $result = Yii::$app->redis->executeCommand('EXEC');

        d([
            'Задача 3',
            //$valueKey4_1,
            //$valueKey4_2,
            $result,
        ]);

        /**
         *  Задача 4, продемонстрировать основные строковые операции.
         */
        Yii::$app->redis->executeCommand('SET', ['folder:test:key5', 'Hello']);
        /* склеить строки (вернет длинну получившейся строки) */
        $lenchKey5_1 = Yii::$app->redis->executeCommand('APPEND', ['folder:test:key5', ' world!']);
        $valueKey5_1 = Yii::$app->redis->executeCommand('GET', ['folder:test:key5']);
        /* получить длинну строки */
        $lenchKey5_2 = Yii::$app->redis->executeCommand('STRLEN', ['folder:test:key5']);
        /* получить фрагмент строки (с 6 по 10 символы) */
        $valueKey5_2 = Yii::$app->redis->executeCommand('GETRANGE', ['folder:test:key5', 6, 10]);
        /* вставить строку после символа (6) */
        Yii::$app->redis->executeCommand('SETRANGE', ['folder:test:key5', 6, 'setyes!']);
        $valueKey5_3 = Yii::$app->redis->executeCommand('GET', ['folder:test:key5']);

        d([
            'Задача 4',
            $lenchKey5_1,
            $valueKey5_1,
            $lenchKey5_2,
            $valueKey5_2,
            $valueKey5_3,
        ]);

        /**
         *  Задача 5, продемонстрировать операции над числами.
         */
        Yii::$app->redis->executeCommand('SET', ['folder:test:key6', 0]);
        /* прибавить на 1 */
        Yii::$app->redis->executeCommand('INCR', ['folder:test:key6']);
        Yii::$app->redis->executeCommand('INCR', ['folder:test:key6']);
        /* уменьшить на 1 */
        Yii::$app->redis->executeCommand('DECR', ['folder:test:key6']);
        /* прибавить на число (20) */
        Yii::$app->redis->executeCommand('INCRBY', ['folder:test:key6', 20]);
        $valueKey6_1 = Yii::$app->redis->executeCommand('GET', ['folder:test:key6']);
        /* уменьшить на число (40) */
        Yii::$app->redis->executeCommand('DECRBY', ['folder:test:key6', 40]);
        $valueKey6_2 = Yii::$app->redis->executeCommand('GET', ['folder:test:key6']);
        d([
            'Задача 5',
            $valueKey6_1,
            $valueKey6_2,
        ]);

        /**
         *  Задача 6, создать список, продемонстрировать основные операции над списками.
         */

        /* создать элементы списка */
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Hello, world!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Hello, user!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Wow!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Hello, user!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Wow!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Hello, user!"]);
        Yii::$app->redis->executeCommand('RPUSH', ['folder:test:key7', "Wow!"]);
        /* получить список */
        $list = Yii::$app->redis->executeCommand('LRANGE', ['folder:test:key7', 0, 10]);
        /* получить количество элементов в списке */
        $listLen = Yii::$app->redis->executeCommand('LLEN', ['folder:test:key7']);
        /* удалить элементы списка */
        Yii::$app->redis->executeCommand('LREM', ['folder:test:key7', -1, "Hello, user!"]);
        Yii::$app->redis->executeCommand('LPOP', ['folder:test:key7']);
        $list2 = Yii::$app->redis->executeCommand('LRANGE', ['folder:test:key7', 0, 10]);

        d([
            'Задача 6',
            $list,
            $listLen,
            $list2,
        ]);

        /**
         *  Задача 7, создать множество, продемонстрировать основные операции над множествами.
         */

        d([
            'Задача 7',

        ]);

        Yii::$app->cache->set('cacheElem', '30 second', 30);
        Yii::$app->session->set('sessionElem', '30 second');

        //$query1 = RedisModel::find()->where(['phone' => '79221301879'])->one(); // find by query
        $query2 = RedisModel::find()->all(); // find all by query (using the `active` scope)

        return $this->render('index', [
            'query1' => $query2,
            //'query2' => $query2
        ]);
    }
}
