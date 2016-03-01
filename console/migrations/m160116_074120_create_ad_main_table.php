<?php

use yii\db\Migration;

class m160116_074120_create_ad_main_table extends Migration
{
    public function safeUp()
    {
        /* Создаем таблицу  ad_reference_main, в которой будут хранится основные свойства объявлений (категория, ед. измерения, валюта) */
        $this->createTable('ad_main_reference', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),           // Номер справочного раздела
            'reference_name' => $this->string()->notNull(),         // Название элемента
        ]);

        /* Добавляем основные свойства */
        $this->batchInsert('ad_main_reference', ['id', 'reference_id', 'reference_name'],
            [
                /* Главные категории объявлений */
                [1, 1, Yii::t('references', 'Real Estate')],
                [2, 1, Yii::t('references', 'Transport')],
                [3, 1, Yii::t('references', 'Consumer electronics')],
                [4, 1, Yii::t('references', 'Clothes and shoes')],
                [5, 1, Yii::t('references', 'Children’s World')],
                [6, 1, Yii::t('references', 'Work')],
                [7, 1, Yii::t('references', 'Animals')],
            ]);

        /* Создаем таблицу  ad_category, в которой будут записываться id объявления и категория этого объявления. Связана с таблицами ad_main и таблицей объявлений. */
        $this->createTable('ad_category', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),           // Номер категории из таблицы ad_main_reference. Связь с таблицей  ad_main_reference.
            'ad_id' => $this->integer(),                  // Номер объявления. Связь с объявлением с одной из таблиц разделов (недвижимость, транспорт или др.)
        ]);

        $this->addForeignKey('ad_category_main_reference', 'ad_category', 'category', 'ad_main_reference', 'id');
        //$this->addForeignKey('ad_category_images_of_objects', 'images_of_object', 'object_id', 'ad_category', 'ad_id');

        /* Создаем таблицу  ad_style, в которой будут находится стили для объявлений.
           Стиль с id = 1 доступен для всех пользователей, другие стили доступны только премиум пользователям. */
        $this->createTable('ad_style', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'main_container_class' => $this->string(32),        // Класс контейнера
            'header_link_class' => $this->string(32),           // Класс для ссылки в заголовке
            'favorite_icon' => $this->string(255),              // Иконка "Добавить в избранное"
            'favorite_icon_empty' => $this->string(255),              // Иконка "Добавить в избранное"
            'complain_icon' => $this->string(255),              // Иконка "Пожаловаться"
            'quick_view_class' => $this->string(32),            // Класс для кнопки "Быстрый просмотр"
        ]);

        /* Добавляем стиль по умолчанию */
        $this->batchInsert('ad_style', ['id','name', 'main_container_class', 'header_link_class', 'favorite_icon', 'favorite_icon_empty', 'complain_icon', 'quick_view_class'],
            [
                [1, Yii::t('references', 'Default'), 'alert', 'header-link-class', 'glyphicon glyphicon-ok-sign', 'glyphicon glyphicon-remove-sign', 'glyphicon glyphicon-ban-circle', 'btn btn-default'],
                [2, Yii::t('references', 'Grass'), 'alert alert-success', 'header-link-class', 'glyphicon glyphicon-ok-sign', 'glyphicon glyphicon-remove-sign', 'glyphicon glyphicon-ban-circle', 'btn btn-success'],
                [3, Yii::t('references', 'Sky'), 'alert alert-info', 'header-link-class', 'glyphicon glyphicon-ok-sign', 'glyphicon glyphicon-remove-sign', 'glyphicon glyphicon-ban-circle', 'btn btn-info'],
                [4, Yii::t('references', 'Sand'), 'alert alert-warning', 'header-link-class', 'glyphicon glyphicon-ok-sign', 'glyphicon glyphicon-remove-sign', 'glyphicon glyphicon-ban-circle', 'btn btn-warning'],
                [5, Yii::t('references', 'Rose'), 'alert alert-danger', 'header-link-class', 'glyphicon glyphicon-ok-sign', 'glyphicon glyphicon-remove-sign', 'glyphicon glyphicon-ban-circle', 'btn btn-danger'],
            ]);

        /* Создаем таблицу  ad_main, в которой будут присутствовать поля, имеющиеся во всех объявлениях */
        $this->createTable('ad_main', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),           // Пользователь, который добавил объявление (обязательно). Связь с таблицей user
            'place_city_id' => $this->integer(),     // Город, для которого добавлено объявление. Связь с таблицей place_city
            'category_id' => $this->integer()->notNull(),    // Тема объявления. Связь с таблицей ad_category
            'ad_style_id' => $this->integer()->defaultValue(1),       // Стиль объявления. Связь с таблицей ad_style
            'phone_temp_ad' => $this->string(32),
            'link_temp_ad' => $this->string(255),
            'checked' => $this->boolean()->defaultValue('0'),       // Поля для флага модерации
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('ad_main_user', 'ad_main', 'user_id', 'user', 'id');
        $this->addForeignKey('ad_main_place_city', 'ad_main', 'place_city_id', 'place_city', 'id');
        $this->addForeignKey('ad_main_category', 'ad_main', 'category_id', 'ad_category', 'id');
        $this->addForeignKey('ad_main_style', 'ad_main', 'ad_style_id', 'ad_style', 'id');

        /* Создаем таблицу  ad_favorite, в которой будут записаваться избранные объявления */
        $this->createTable('ad_favorite', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),           // Пользователь, который добавил объявление в избранное. Связь с таблицей user
            'ad_id' => $this->integer()->notNull(),             // Объявление, добавленное в избранное
        ]);

        $this->addForeignKey('ad_favorite_user', 'ad_favorite', 'user_id', 'user', 'id');
        $this->addForeignKey('ad_favorite_ad_main', 'ad_favorite', 'ad_id', 'ad_main', 'id');

        /* Создаем таблицу  ad_complaints, в которой будут записаваться жалобы на объявления */
        $this->createTable('ad_complains', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),           // Пользователь, который добавил объявление в избранное. Связь с таблицей user
            'ad_id' => $this->integer()->notNull(),             // Объявление, добавленное в избранное
        ]);

        $this->addForeignKey('ad_complains_user', 'ad_complains', 'user_id', 'user', 'id');
        $this->addForeignKey('ad_complains_ad_main', 'ad_complains', 'ad_id', 'ad_main', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('ad_main_place_city', 'ad_main');
        $this->dropForeignKey('ad_main_user', 'ad_main');
        $this->dropTable('ad_main');
        $this->dropForeignKey('ad_category_main_reference', 'ad_category');
        $this->dropTable('ad_category');
        $this->dropTable('ad_main_reference');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
