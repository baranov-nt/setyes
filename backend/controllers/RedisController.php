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

        /* создание множества */
        Yii::$app->redis->executeCommand('SADD', ['folder:test:fruits', 'banana']);
        Yii::$app->redis->executeCommand('SADD', ['folder:test:fruits', 'apple']);
        Yii::$app->redis->executeCommand('SADD', ['folder:test:fruits', 'strawberry']);
        Yii::$app->redis->executeCommand('SADD', ['folder:test:yellowThings', 'banana']);
        Yii::$app->redis->executeCommand('SADD', ['folder:test:yellowThings', 'apple']);
        Yii::$app->redis->executeCommand('SADD', ['folder:test:redThings', 'strawberry']);
        /* получение количества элементов множества */
        $haveElements = Yii::$app->redis->executeCommand('SCARD', ['folder:test:fruits']);
        /* сравнение элементов множества (вернет различие) */
        $haveDiff = Yii::$app->redis->executeCommand('SDIFF', ['folder:test:fruits', 'folder:test:yellowThings']);
        /* записывает различие в новый ключ noYellowFruits */
        Yii::$app->redis->executeCommand('SDIFFSTORE', ['folder:test:noYellowFruits', 'folder:test:fruits', 'folder:test:yellowThings']);
        /* сравнение элементов множества (вернет входящие) */
        $haveInter = Yii::$app->redis->executeCommand('SINTER', ['folder:test:fruits', 'folder:test:yellowThings']);
        /* находит элемент в множестве (1 - найден, 0 - нет) */
        Yii::$app->redis->executeCommand('SISMEMBER', ['folder:test:fruits', 'banana']);
        Yii::$app->redis->executeCommand('SISMEMBER', ['folder:test:fruits', 'tomato']);
        /* перемещает элемент (1 - да, 0 - нет) */
        Yii::$app->redis->executeCommand('SMOVE', ['folder:test:yellowThings', 'folder:test:redThings', 'apple']);
        /* возвращает элементы множества */
        $haveMembers = Yii::$app->redis->executeCommand('SMEMBERS', ['folder:test:redThings']);
        /* удаляет случайный элемент множества */
        Yii::$app->redis->executeCommand('SADD', ['folder:test:redThings', 'tomato']);
        $deleteMember = Yii::$app->redis->executeCommand('SPOP', ['folder:test:redThings']);
        $deleteMember2 = Yii::$app->redis->executeCommand('SRANDMEMBER', ['folder:test:redThings']);
        $haveMembers2 = Yii::$app->redis->executeCommand('SMEMBERS', ['folder:test:redThings']);
        /* удалить заданный элемент (1 - да, 0 - нет) */
        Yii::$app->redis->executeCommand('SADD', ['folder:test:yellowThings', 'melon']);
        Yii::$app->redis->executeCommand('SREM', ['folder:test:yellowThings', 'banana']);
        /* возвращает входящие (не повторяющиеся) элементы */
        $unionElements = Yii::$app->redis->executeCommand('SUNION', ['folder:test:yellowThings', 'folder:test:redThings', 'folder:test:fruits']);
        /* сохраняет входящие (не повторяющиеся) элементы в отдельно множество */
        $unionElements2 = Yii::$app->redis->executeCommand('SUNIONSTORE', ['folder:test:allThings', 'folder:test:yellowThings', 'folder:test:redThings', 'folder:test:fruits']);

        d([
            'Задача 7',
            $haveElements,
            $haveDiff,
            $haveInter,
            $haveMembers,
            $deleteMember,
            $deleteMember2,
            $haveMembers2,
            $unionElements,
            $unionElements2
        ]);

        /**
         *  Задача 8, создать упорядоченное множество и продемонстрировано основные операции над ним.
         * В упорядоченном множестве элементы сравниваются по дополнительному параметру «score».
         */
        /* создание элементов (год - параметр score) */
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1953, "Richard Stallman"]);
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1940, "Alan Kay"]);
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1965, "Yukihiro Matsumoto"]);
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1916, "Claude Shannon"]);
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1969, "Linus Torvalds"]);
        Yii::$app->redis->executeCommand('ZADD', ['folder:test:hackers', 1912, "Alan Turing"]);
        /* возвращает элементы по row (ZRANGE key start stop [WITHSCORES]) (если stop = -1 до последнего) */
        $haveElements = Yii::$app->redis->executeCommand('ZRANGE', ['folder:test:hackers', 0, -1]);
        /* возвращает элементы по row в обратном порядке (ZREVRANGE key start stop [WITHSCORES]) (если stop = -1 до последнего) */
        $haveRevElements = Yii::$app->redis->executeCommand('ZREVRANGE', ['folder:test:hackers', 0, -1]);
        /* возвращает элементы по score ( -inf - меньше, или диапозон) */
        $haveRangeLessElements = Yii::$app->redis->executeCommand('ZRANGEBYSCORE', ['folder:test:hackers', '-inf', 1950]);
        $haveRangeMoreElements = Yii::$app->redis->executeCommand('ZRANGEBYSCORE', ['folder:test:hackers', 1940, 2000]);

        d([
            'Задача 8',
            $haveElements,
            $haveRevElements,
            $haveRangeLessElements,
            $haveRangeMoreElements,
        ]);

        /**
         *  Задача 9, Создать хеш-таблицу и продемонстрировать основные операции над хешами.
         */

        /* создание колонки */
        Yii::$app->redis->executeCommand('HSET', ['folder:test:users:1', 'name', 'Andrew']);
        Yii::$app->redis->executeCommand('HSET', ['folder:test:users:1', 'email', 'andrew@example.com']);
        /* получение ключей */
        $hkeys = Yii::$app->redis->executeCommand('HKEYS', ['folder:test:users:1']);
        /* получение значений */
        $hvals = Yii::$app->redis->executeCommand('HVALS', ['folder:test:users:1']);
        /* получение ключей - значений */
        $hgetall = Yii::$app->redis->executeCommand('HGETALL', ['folder:test:users:1']);
        /* прибавление */
        Yii::$app->redis->executeCommand('HSET', ['folder:test:users:1', 'test', 25]);
        Yii::$app->redis->executeCommand('HINCRBY', ['folder:test:users:1', 'test', 25]);
        /* удаление */
        Yii::$app->redis->executeCommand('HDEL', ['folder:test:users:1', 'test']);

        d([
            'Задача 9',
            $hkeys,
            $hvals,
            $hgetall,
        ]);

        /**
         *  Задача 10, подписаться на сообщения на одном клиенте и отправить сообщение из другого.
        Приведем окна двух клиентов, в первом окне совершается подписка на сообщения и видно отправленное из второго окна сообщение.
        redis 127.0.0.1:6379> SUBSCRIBE messages
        Reading messages... (press Ctrl-C to quit)
        1) "subscribe"
        2) "messages"
        3) (integer) 1
        1) "message"
        2) "messages"
        3) "Hello world!"
         *
        redis 127.0.0.1:6379> PUBLISH messages "Hello world!"
        (integer) 1
         *
         */

        /* (1 - успешно, 0 - нет) */
        $publish = Yii::$app->redis->executeCommand('PUBLISH', [
            'channel' => 'mes',
            'message' => Json::encode(['name' => 'Petia', 'message' => 'УРА!!! РАБОТАЕТ!!!!'])
        ]);

        d([
            'Задача 10',
            $publish
        ]);

        /**
         *  Задача 11
         */

        /*$publish = Yii::$app->redis->executeCommand('PSUBSCRIBE', [
            'folder:test:fruits:*'
        ]);*/

        d([
            'Задача 11',
            $publish
        ]);

        //$query1 = RedisModel::find()->where(['phone' => '79221301879'])->one(); // find by query
        $query2 = RedisModel::find()->all(); // find all by query (using the `active` scope)

        return $this->render('index', [
            'query1' => $query2,
            //'query2' => $query2
        ]);
    }
}
