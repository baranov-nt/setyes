<?php

namespace backend\controllers;

use common\models\Images;
use Yii;
use yii\db\Query;
use common\models\User;
use common\models\Profile;
use yii\db\ActiveRecord;
use yii\db\Expression;

class DbController extends BehaviorsController
{
    /**
     * @return string
     */
    /* $TTerminal = TTerminal::find()
    ->joinWith([
     'tAdvShedules' => function ($query) {
      $query->leftJoin(TAdv::tablename().' adv', 'adv.period = '.$_POST['selectTime']);
      $query->andWhere('t_advShedule.status IN (-2, 1) AND startdate <= '.$_POST['start_date'].' AND enddate >= '.$_POST['end_date']);
     }
    ])
    ->where($sql)
    ->orderBy('id_terminal ASC')
    ->all(); */
    public function actionActiveRecordJoin()
    {
        // Работа с Active Record используя Join

        // SELECT `customer`.* FROM `customer`
        // LEFT JOIN `order` ON `order`.`customer_id` = `customer`.`id`
        // WHERE `order`.`status` = 1
        //
        // SELECT * FROM `order` WHERE `customer_id` IN (...)
        /*$model = Profile::find()
            ->select('profile.*')
            ->leftJoin('auth_assignment', '`auth_assignment`.`user_id` = `profile`.`user_id`')                          // условие, достать только с ролью "Пользователь"
            ->where(['auth_assignment.item_name' => 'Создатель'])                                                       // условие, достать только с ролью "Пользователь"
            ->with(['user', 'imagesOfObjects'])                                                                         // здесь дополнительная связь к таблицам, которые нужно вытащить
            ->all();*/

        // Лучше так
        /*$model = Profile::find()
            ->select('profile.*')
            ->innerJoinWith('user', '`user`.`id` = `profile`.`user_id`')                          // условие, достать только с ролью "Пользователь"
            ->where(['user.email' => 'v@v.com'])                                                  // условие, достать только с ролью "Пользователь"
            ->with(['imagesOfObjects.image'])                                                     // здесь дополнительная связь к таблицам, которые нужно вытащить
            ->all();*/

        // или так
        /*$model = Profile::find()->joinWith([
            'user' => function ($query) {
                $query->andWhere(['<', 'id', 5])
                ->select(['user.id', 'user.email', 'user.phone']);                                 // выборочные поля из user
            },
        ])->with(['imagesOfObjects.image'])
            ->all();*/

        // или так
        /*$model = Profile::find()->innerJoinWith([
            'user' => function ($query) {
                $query->andWhere(['<', 'id', 5])
                    ->select(['user.id', 'user.email', 'user.phone']);                                 // выборочные поля из user
            },
        ])->all();*/

        // получить данные много ко многим через модель см getImages() которая использует getImagesOfObjects() в модели Profile
        /*$model = Profile::find()
            ->where(['user_id' => 1])
            //->innerJoinWith([                         // если найдет images, тогда достанет пользователя
            ->joinWith([                                // достанет пользователя, даже если не найдет images
            'images' => function ($query) {
            },
        ])->one();*/

        // или
        //$model = Profile::findOne(1);

        // получить данные много ко многим через модель см getImages() которая использует getImagesOfObjects() в модели Profile
        //d($model->images);


        // Join с дополнительным условием CONDITION (возвращает true, если условие истинно)
        /*$model = Profile::find()->innerJoinWith([
            'user' => function ($query) {
                $query->onCondition(['user.status' => User::STATUS_NOT_ACTIVE]);
            },
        ])->all();*/

        // или так
        /*$model = Profile::find()->joinWith([
            'user' => function ($query) {
                $query->onCondition(['user.status' => User::STATUS_NOT_ACTIVE]);        // если условие верно, таблицы объединяются. Отличается от where, который возвращает только
                                                                                        // один профили с верным условием, тем, что возвращает все профили, а где условие верно
                                                                                        // добавляет связанную таблицу. Если использовать innerJoinWith(), будет работать как where()
            },
        ])->all();*/

        // Обратные связи. Смотри модель User inverseOf() Например есть код:
        // SELECT * FROM `user` WHERE `id` = 1
        //$model = User::findOne(1);
        // SELECT * FROM `profile` WHERE `user_id` = 1
        //$profile = $model->profile2[0];
        // SQL-запрос не выполняется
        //$model2 = $profile->user;
        // выведет "одинаковы"
        //echo ($model === $model2) ? 'одинаковы' : 'НЕ одинаковы';


        $model = Profile::find()->joinWith([
            'user' => function ($query) {
                $query->onCondition(['user.status' => User::STATUS_NOT_ACTIVE]);
            },
        ])->all();

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
    public function actionActiveRecord()
    {
        // -------------------------------------------------------------------------------------------------------------
        // Active Record

        // Получение данных
        /*$model = User::find()
            ->where(['id' => [1,2,3]])
            ->andWhere(['email' => 'user3@user3.com'])
            ->orWhere(['email' => 'v@v.com'])
            ->all();*/

        /*$model = User::find()
            ->where(['id' => [1,2,3]])
            ->orderBy(['id' => SORT_DESC])
            ->count();*/

        /*$model = User::findOne([
            'id' => 1,
            'status' => User::STATUS_ACTIVE,
        ]);*/

        // Получение данных в виде массива
        /*$model = User::find()
            ->where(['id' => [1,2,3]])
            ->asArray()
            ->all();*/

        // Пакетное получение данных
        // получить 10 покупателей одновременно
        /*foreach (User::find()->batch(10) as $model) {
            // $models - это массив, в котором находится 10 или меньше объектов класса User
        }*/

        // получить одновременно десять покупателей и перебрать их одного за другим
        /*foreach (User::find()->each(10) as $model) {
            // $model - это объект класса User
        }*/

        // пакетная выборка с жадной загрузкой
        /*foreach (User::find()->with('profile')->each() as $model) {
            // $model - это объекта класса User
        }*/

        // вставить новую строку данных
        /*$model = new User();
        $model->phone = '9221301818';
        $model->email = 'james@example.com';
        $model->save();*/

        // обновить имеющуюся строку данных
        /*$model = User::findOne(3);
        $model->email = 'james@newexample.com';
        $model->save();*/

        // Dirty-атрибуты
         /*Active Record автоматически поддерживает список dirty-атрибутов. Это достигается за счёт хранения старых значений атрибутов и сравнения их с новыми.
         * Вы можете вызвать метод yii\db\ActiveRecord::getDirtyAttributes() для получения текущего списка dirty-атрибутов.
         * Вы также можете вызвать yii\db\ActiveRecord::markAttributeDirty(), чтобы явно пометить атрибут в качестве dirty-атрибута.
         * Если вам нужны значения атрибутов, какими они были до их изменения, вы можете вызвать getOldAttributes() или getOldAttribute().*/

        // Значения атрибутов по умолчанию
        /*$model = new Profile();
        $model->loadDefaultValues();*/

        // Обновление нескольких строк данных
        // UPDATE `profile` SET `images_num`=2 WHERE `middle_name` LIKE '%@example.com%'
        // $model = Profile::updateAll(['images_num' => 2], ['like', 'middle_name', '@example.com']);

        // Работа с транзакциями
        /*$model = Profile::findOne(1);

        $transaction = Profile::getDb()->beginTransaction();
        try {
            $model->user_id = 1;
            $model->birthday = 'sdfsdfsdf';
            $model->save();
            // ...другие операции с базой данных...
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }*/

        // Работа со связными данными
        // Объявление связей в модели
        /*public function getProfile()
        {
            return $this->hasOne(Profile::className(), ['user_id' => 'id']);
        }*/

        // Доступ к связным данным
        /*$model = User::findOne(3);
        $model = $model->profile;*/

        // Динамические запросы связных данных. Смотри в модель Profile
        // $model = Profile::findOne(1);
        // SELECT * FROM `order` WHERE `subtotal` > 200 ORDER BY `id`
        // $model = $model->getRelationTest(10)->all();

        /*public function getRelationTest($value = 10)
        {
            return $this->hasOne(User::className(), ['id' => 'user_id'])
                ->where('status >= :value', [':value' => $value])
                ->andWhere(['email' => 'v@v.com'])
                ->orderBy('id');
        }*/

        /*public function getRelationManyToMany()
        {
            return $this->hasMany(ImagesOfObject::className(),
                [
                    'object_id' => 'user_id',
                    'label' => 'images_label'
                ])
                ->viaTable('images', ['id' => 'user_id']);
        }*/

        // жадная загрузка "profile" и "auths" одновременно
        // $model = User::find()->with('profile', 'auths')->all();

        // жадная загрузка "user" и "ImagesOfObjects.image" одновременно с вложенной связью
        // $model = Profile::find()->with('user', 'imagesOfObjects.image')->all();

        // найти покупателей и получить их вместе с их странами и активными заказами
        // SELECT * FROM `profile`
        // SELECT * FROM `user` WHERE `id` IN (...)
        // SELECT * FROM `order` WHERE `customer_id` IN (...) AND `status` = 1

        // Сохранение связных данных
        /*$user = User::findOne(3);
        $profile = new Profile();
        $profile->middle_name = 'Петрович';
        $profile->link('user', $user);          // link(<связь>,<объект>) - создаст запись в таблице profile и подставит в user_id id связанного объекта*/

        // Использование CASE WHEN
        //$case_1 = new Expression('CASE WHEN true THEN email ELSE (\'phone\') END');
        $case_1 = new Expression('CASE WHEN id=1 THEN email ELSE (phone) END');
        $case_2 = new Expression('CASE WHEN id=2 THEN password_hash ELSE (phone) END');

        $model = User::find()
            ->select([
                'case_1' => $case_1,
                'case_2' => $case_2
            ])
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
    public function actionQueryJoin()
    {
        // -------------------------------------------------------------------------------------------------------------
        // Конструктор запросов
        // http://www.sitepoint.com/understanding-sql-joins-mysql-database/
        // Метод JOIN
        // Принимает чатыре параметра:
        // $type -  INNER JOIN (извлекает строки, которые обязательно присутствую во всех объединяемых таблицах) - вытаскивает объединенные данные
        //          LEFT JOIN (дополняет данные одной таблицы из второй) - вытаскивает все
        //          RIGHT JOIN (дополняет данные второй таблицы из первой)
        // $table - имя таблицы, которая должна быть присоединена
        // $on - условие объединения (необязательно)
        // $params - необязательные параметры присоединяемые к условию объединения

        // SELECT column_name(s)
        // FROM table1
        // LEFT JOIN table2
        // ON table1.column_name=table2.column_name;

        // Создает запрос SELECT * FROM `auth_assignment` `a` LEFT JOIN `user` ON a.user_id = user.id
        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->join('LEFT JOIN', 'user', 'a.user_id = user.id')
            ->all();*/

        // Объединение с несколькими таблицами
        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->join('LEFT JOIN', 'user', 'a.user_id = user.id')
            ->join('LEFT JOIN', 'auth_item', 'a.item_name = auth_item.name')
            ->all();*/

        // Объединение с подзапросом
        /*$subQuery = (new \yii\db\Query())->from('user')->where(['id' => 4]);

        $model = (new \yii\db\Query())
            ->from(['a' => 'profile'])
            ->innerJoin(['u' => $subQuery], 'u.id = user_id')
            ->all();*/

        // Пакетная выборка
        /*$query = (new Query())
            ->from('user')
            ->orderBy('id');

        foreach ($query->batch(5) as $users) {
            // $users это массив из 100 или менее строк из таблицы пользователей
            d($users);
        }*/

        // или если вы хотите перебрать все строки по одной
        /*foreach ($query->each() as $user) {
            // $user представляет одну строку из выборки
            d($user);
        }*/

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
    public function actionQuery()
    {
        /* -------------------------------------------------------------------------------------------------------------------------------------
        * Выполнение запроса через Query (конструктор запросы) */

        // all(): возвращает массив строк, каждая из которых это ассоциативный массив пар ключ-значение.
        // one(): возвращает первую строку запроса.
        // column(): возвращает первый столбец результата.
        // scalar(): возвращает скалярное значение первого столбца первой строки результата.
        // exists(): возвращает значение указывающее, что выборка содержит результат.
        // count(): возвращает результат COUNT запроса.
        // Другие методы агрегирования запросов, включая sum($q), average($q), max($q), min($q). Параметр $q обязателен для этих методов и могут содержать либо имя столбца,
        // либо выражение БД.
        //
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

        // Создает следующий запрос - (`u`.`id` IN (1, 3, 7)) AND (`emails` LIKE '%user%' AND `email` LIKE '%.com%')
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where([
                'u.id' => [1, 3, 7]
            ])
            ->andWhere(['like', 'email', ['user', '.com']])
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

        // Создает следующий запрос - `email` LIKE '%user%' OR `emaild` LIKE '%v@%'
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['or like', 'email', ['user', 'v@']])
            ->all();*/

        // `email` NOT LIKE '%user3%' AND `email` NOT LIKE
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['not like', 'email', ['user3', 'v@v.com']])
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
        /*$model = (new \yii\db\Query())
            ->select(['a.user_id'])
            ->from(['a' => 'auth_assignment'])
            ->where(['not between', 'user_id', 5, 10])
            ->all();*/

        // Оператор IN

        // ['in', 'id', [1, 2]] - cоздает следующий запрос - `id` IN (1, 2)
        // или с доп запросом
        /*$assignment = (new Query())->select('user_id')->from('auth_assignment');
        $model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['in', 'id', $assignment])
            ->all();*/

        // ['not in', 'id', [1, 2]] - cоздает следующий запрос - `id` NOT IN (1, 2)
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['not in', 'id', [1, 2]])
            ->all();*/

        // Оператор EXISTS

        // Выполняет запрос, если проходит подзапрос
        /*$assignment = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'Администратор']);
        $model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['exists', $assignment])
            ->all();*/

        // Выполняет запрос, если НЕ проходит подзапрос
        /*$assignment = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'Администратор']);
        $model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['not exists', $assignment])
            ->all();*/

        // Добавление условий
        /*$model = (new \yii\db\Query())
            ->select(['u.id'])
            ->from(['u' => 'user'])
            ->where(['id' => [2,3]])
            ->andWhere(['status' => 10])
            ->orWhere(['email' => 'v@v.com'])
            ->all();*/

        // filterWhere() - игнорирует пустые значения
        //$firstName = 'dfg';
        /*$secondName = 'dfgdfgdfg';

        $model = (new \yii\db\Query())
            ->select(['p.user_id'])
            ->from(['p' => 'profile'])
            ->filterWhere(['first_name' => $firstName, 'second_name' => $secondName])
            ->all();*/

        // Оператор ORDER BY
        // orderBy() - сортировка

        /*$model = (new \yii\db\Query())
            ->from(['p' => 'profile'])
            ->orderBy(['first_name' => SORT_DESC, 'second_name' => SORT_ASC])
            ->all();*/

        // Оператор GROUP BY
        // groupBy() - группировка
        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->groupBy(['item_name', 'user_id'])
            ->all();*/

        // Оператор HAVING
        // having() - !!! используется при наличии groupBy(), сразу после него. Иначе лучше использовать where() !!!
        // andHaving() и orHaving() - дополнительные условия
        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->groupBy(['item_name', 'user_id'])
            ->having(['item_name' => 'Администратор'])
            ->andHaving(['<', 'user_id', 5])
            ->all();*/

        // Оператор LIMIT
        // limit() - максимальное кол-во записей, которые нужно достать
        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->groupBy(['user_id'])
            ->limit(5)
            ->all();*/

        // Оператор OFFSET
        // offset() - смещение относитьно первого элемента

        /*$model = (new \yii\db\Query())
            ->from(['a' => 'auth_assignment'])
            ->groupBy(['user_id'])
            ->limit(5)
            ->offset(5)
            ->all();*/

        // Метод UNION
        /*$query1 = (new \yii\db\Query())
            ->select(['user_id' => 'id'])
            ->from('user');

        $query2 = (new \yii\db\Query())
            ->select(['user_id'])
            ->from('profile');

        $model = $query1->union($query2)->all();*/

        // Вывод сформированную sql команду
        /*$command = (new \yii\db\Query())
            ->select(['id', 'email'])
            ->from('user')
            ->where(['phone' => 'Smith'])
            ->limit(10)
            ->createCommand();*/

        // показать SQL запрос
        //d($command->sql);
        // показать привязываемые параметры
        //d($command->params);

        // возвращает все строки запроса
        //$rows = $command->queryAll();

        // Индексация результатов запроса
        // возвращает [100 => ['id' => 100, 'username' => '...', ...], 101 => [...], 103 => [...], ...]
        /*$model = (new \yii\db\Query())
            ->from('user')
            ->limit(10)
            ->indexBy('id')
            ->all();*/

        // Индексация результатов запроса с использование нескольких полей.
        // Анонимная функция должна принимать параметр $row, который содержит текущую строку запроса и должна
        // вернуть скалярное значение, которое будет использоваться как значение индекса для текущей строки.

        $model = (new \yii\db\Query())
        ->from('user')
        ->indexBy(function ($row) {
            return $row['id'].' '.$row['email'];
        })->all();

        // Использование CASE WHEN
        //$case_1 = new Expression('CASE WHEN true THEN email ELSE (\'phone\') END');
        //$case_1 = new Expression('CASE WHEN id=1 THEN email ELSE (phone) END');
        $case_2 = new Expression('CASE WHEN id=2 THEN password_hash ELSE (phone) END');
        $case_3 = new Expression('CASE WHEN profile.middle_name IS NULL THEN profile.second_name ELSE profile.middle_name END');

        $model = (new \yii\db\Query())
            ->select([
                'id',
                'user_id',
                //'case_1' => $case_1,
                'case_2' => $case_2,
                'case_3' => $case_3
            ])
            ->from(['user', 'profile'])
            ->groupBy('user_id')
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
