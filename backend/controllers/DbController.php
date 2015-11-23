<?php

namespace backend\controllers;

use Yii;
use yii\db\Query;

class DbController extends BehaviorsController
{
    /**
     * @return string
     */
    public function actionQuery()
    {
        /* -------------------------------------------------------------------------------------------------------------------------------------
        * Выполнение запроса через Query (конструктор запросы) */
        // select() - указываются столбцы, которые должны быть выбраны. Если нет select(), будет использоваться *
        // select(['id']) - выбрать поле id из таблицы user
        // select('id AS user_id, email') - выбрать поля id как user_id и email
        // select('user.id AS user_id, email') - выбрать поля id как user_id из таблицы user и email
        // select(['user_id' => 'user.id', 'email']) - выбрать поля id как user_id из таблицы user и email, но в формате массива
        // select(['full_name' => 'CONCAT(first_name, " ", second_name)', 'birthday']) - внутри используется SQL. Соединить поля first_name и second_name в одно full_name и достать birthday
        // $subQuery = (new Query())->select('COUNT(*)')->from('user'); - подзапрос в select() ниже. Может содержать только строку, а не массив
        // select(['count' => $subQuery, 'first_name']) - использование с подзапросом

        /*$subQuery = (new Query())->select('COUNT(*)')->from('user');
        $model = (new \yii\db\Query())
            ->select(['count' => $subQuery, 'first_name'])
            ->from(['profile'])
            ->all();*/

        // select('id')->distinct() - выберает конкретные поляю Чаще всего DISTINCT применяется во вложенных запросах
        // и при объединении таблиц (JOIN) когда необходимо исключить повторяющиеся данные.

        /*$model = (new \yii\db\Query())
            ->select('id')->distinct()
            ->from(['user'])
            ->all();*/

        // addSelect() - добавления полей к выборке

        /*$model = (new \yii\db\Query())
            ->select(['id'])
            ->from(['user'])
            ->addSelect(['email', 'status'])
            ->all();*/

        // from() - указывает фрагмент FROM SQL запроса
        // from(['u' => 'user', 'p' => 'profile']) - выборка из нескольких таблиц. Алиасы u и p указываются перед полями в select(['u.id', 'p.first_name'])

        /*$model = (new \yii\db\Query())
            ->select(['u.id', 'p.first_name'])
            ->from(['u' => 'user', 'p' => 'profile'])
            ->all();*/

        // использование с подзапросом
        /*$subQuery = (new Query())
            ->select([
                'f_name' => 'first_name',
                's_name' => 'second_name',
                'user_id'])
            ->from('profile')
            ->where('images_num=1');

        $model = (new \yii\db\Query())
            ->select(['f_name', 's_name', 'p.user_id'])
            ->from(['p' => $subQuery])
            ->all();*/

        // where() определяет фрагмент WHERE SQL выражения
        // where(['u.id' => [1, 3, 7], 'u.status' => 10]) - выбрать данных у которых все данные соответствуют значениям
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where([
                'u.id' => [1, 3, 7],
                'u.status' => 10
            ])
            ->all();*/

        // where(['LIKE', 'email', 'user']) - означает WHERE `email` LIKE '%user%'
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where([
                'u.id' => [1, 3, 7]
            ])
            ->andWhere(['like', 'email', 'user'])
            ->all();*/

        // where(['NOT LIKE', 'email', 'user']) - означает WHERE `email` NOT LIKE '%user%'
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where([
                'u.id' => [1, 3, 7]
            ])
            ->andWhere(['not like', 'email', 'user'])
            ->all();*/

        // where() - использование с подзапросом, должен быть строкой
        // $userQuery - Подзапрос. Достает id из таблицы user, где email равен user3@user3.com
        // Запрос достает назвение ролей пользователя из таблицы auth_assignment, где user_id будет равен найденному id в подзапросе

        /*$userQuery = (new Query())->select('id')->from('user')->where(['email' => 'user3@user3.com']);

        $model = (new \yii\db\Query())
            ->select(['item_name'])
            ->from(['a' => 'auth_assignment'])
            ->where([
                'user_id' => $userQuery
            ])
            ->all();*/

        // ОПЕРАТОРЫ
        // Оператор AND

        // Создает следующий запрос - (item_name='Администратор') AND (user_id=2)
        // Достанет 'user_id' => '2'
        /*$model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['and', 'item_name=\'Администратор\'', 'user_id=2'])
            ->all();*/

        // Создает следующий запрос - (item_name='Создатель') AND ((user_id=1) OR (user_id=2) OR (user_id=3))
        // Достанет 'user_id' => '1'
        /*$model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['and', 'item_name=\'Создатель\'', ['or', 'user_id=1', 'user_id=2', 'user_id=3']])
            ->all();*/

        // Оператор OR

        // Создает следующий запрос - (item_name='Администратор') OR (item_name='Создатель')
        // Достанет 'user_id' => '2', 'user_id' => '8', 'user_id' => '1'
        /*$model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['or', 'item_name=\'Администратор\'', 'item_name=\'Создатель\''])
            ->all();*/

        // Оператор BETWEEN

        // Создает следующий запрос - `user_id` BETWEEN 5 AND 10
        // Достанет 'user_id' от 5 до 10

        /*$model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['between', 'user_id', 5, 10])
            ->all();*/

        // Создает следующий запрос - `user_id` NOT BETWEEN 5 AND 10
        // Достанет все 'user_id', кроме от 5 до 10
        $model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['not between', 'user_id', 5, 10])
            ->all();



        return $this->render(
            'index',
            [
                'model' => $model
            ]
        );
    }

    /**
     * @return string
     */
    public function actionDao()
    {
        /* -------------------------------------------------------------------------------------------------------------------------------------
        * Выполнение запроса через DAO (SQL запросы) */
        $db = Yii::$app->db;
        // DAO возвращает массив
        // queryAll() - выбрать все объекты
        // queryOne() - выбрать один объект
        // queryScalar() - выбрать скалярную величину
        // execute() - команда выполнить (для Не-SELECT запросов)

        // выбрать все
        /*$model = $db->createCommand('SELECT * FROM user')
            ->queryAll();*/

        // выбрать по условию
        /*$model = $db->createCommand('SELECT * FROM user WHERE id=3')
            ->queryAll();*/

        // выбрать нужные колонки (можно с условием)
        /*$model = $db->createCommand('SELECT phone, email FROM user WHERE id=3')
            ->queryAll();*/

        // выбрать количество записей (можно с условием)
        /*$model = $db->createCommand('SELECT COUNT(*) FROM user')
            ->queryScalar();*/

        // инекции (В DAO ИСПОЛЬЗОВАТЬ ВСЕГДА !!!)
        /*$params = [':id' => 3, ':status' => 10];
        $model = $db->createCommand('SELECT * FROM user WHERE id=:id AND status=:status', $params)
            ->queryOne();*/

        // изменение записи
        /*$model = $db->createCommand('UPDATE user SET  status=10 WHERE id=3')
            ->execute();*/

        // Для запросов INSERT, UPDATE и DELETE можно вызвать методы insert(), update(), delete()
        // INSERT (table name, column values) - добавить запись
        /*$db->createCommand()->insert('user',
            [
                'email' => 'v@v.com',
                'status' => 10,
            ])
            ->execute();*/
        // DELETE (table name, condition)
        /*$db->createCommand()->delete('user',
            [
                'id' => 8,
                'status' => 10
            ])
            ->execute();*/
        // UPDATE (table name, column values, condition)
        /*$model = $db->createCommand()->update('user',
            [
                'status' => 10
            ],
            'id = 3')
            ->execute();*/

        // множественная вставка
        // table name, column names, column values
        /*$model = $db->createCommand()->batchInsert("user",
            [
                'phone',
                'email',
                'status',
                'password_hash',
                'auth_key',
                'created_at',
                'updated_at'
            ],
            [
                ['7 (222) 222-1237', 'user3@user3.com', 10, 'sd78df687sdf6', 'sd78df687sdf6', 1447129776, 1447129776],
                ['7 (222) 222-7543', 'user3@user3.com', 10, 'sd78df687sdf6', 'sd78df687sdf6', 1447129776, 1447129776],
                ['7 (222) 222-2134', 'user3@user3.com', 10, 'sd78df687sdf6', 'sd78df687sdf6', 1447129776, 1447129776],
                ['7 (222) 222-7543', 'user3@user3.com', 10, 'sd78df687sdf6', 'sd78df687sdf6', 1447129776, 1447129776],
                ['7 (222) 222-1242', 'user3@user3.com', 10, 'sd78df687sdf6', 'sd78df687sdf6', 1447129776, 1447129776]
                // может быть сколько угодно
            ])
            ->execute();*/

        // Исполнение транзакций
        $transaction = $db->beginTransaction();
        try {
            $db->createCommand("DELETE FROM user WHERE id = 15")->execute();
            $db->createCommand("INSERT INTO `user` (`email`, `status`) VALUES ('v@v.com', 10)")->execute();
            $model = $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            //throw $e;                         // исключение при ошибке
            $model = $e;                        // вывод исключения в представлении
        }

        return $this->render(
            'index',
            [
                'model' => $model
            ]
        );
    }
}
