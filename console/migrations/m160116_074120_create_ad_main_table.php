<?php

use yii\db\Migration;

class m160116_074120_create_ad_main_table extends Migration
{
    public function safeUp()
    {
        /* Создаем таблицу  ad_reference_main, в которой будут хранится основные свойства объявлений (категория, ед. измерения, валюта) */
        $this->createTable('ad_reference_main', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),           // Номер справочного раздела
            'reference_name' => $this->string()->notNull(),         // Название элемента
        ]);

        /* Добавляем основные свойства */
        $this->batchInsert('ad_reference_main', ['id', 'reference_id', 'reference_name'],
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
            'category' => $this->integer()->notNull(),           // Номер категории из таблицы ad_reference_main. Связь с таблицей  ad_reference_main.
            'ad_id' => $this->integer(),                  // Номер объявления. Связь с объявлением с одной из таблиц разделов (недвижимость, транспорт или др.)
        ]);

        $this->addForeignKey('ad_category_reference_main', 'ad_category', 'category', 'ad_reference_main', 'id');
        //$this->addForeignKey('ad_category_images_of_objects', 'images_of_object', 'object_id', 'ad_category', 'ad_id');

        /* Создаем таблицу  ad_style, в которой будут находится стили для объявлений.
           Стиль с id = 1 доступен для всех пользователей, другие стили доступны только премиум пользователям. */
        $this->createTable('ad_style', [
            'id' => $this->primaryKey(),
            'background-color' => $this->string(32)->defaultValue('#ffffff'),       // Цвет фона
            'bоrder-color' => $this->string(32)->defaultValue('#000000'),           // Цвет рамки
            'border-weight' => $this->smallInteger()->defaultValue(1),              // Толщина рамки (1px - 3px)
            'header-color' => $this->string(32)->defaultValue('#000000'),           // Цвет заголовка
            'text-color' => $this->string(32)->defaultValue('#000000'),             // Цвет текста
            'font-weight' => $this->smallInteger(3)->defaultValue(400),              // Толщина текста (100 - 900)
            'font-family' => $this->string(32)->defaultValue('Verdana'),            // Шрифт текста
            'font-family-style' => $this->string(32)->defaultValue('sans-serif'),   // Стиль шрифта текста
        ]);

        /* Добавляем стиль по умолчанию */
        $this->batchInsert('ad_style', ['id', 'background-color', 'bоrder-color', 'border-weight', 'header-color', 'text-color', 'font-weight', 'font-family', 'font-family-style'],
            [
                [1, '#ffffff', '#000000', 1, '#000000', '#000000', 400, 'Verdana', 'sans-serif'],
            ]);

        /* Создаем таблицу  ad_main, в которой будут присутствовать поля, имеющиеся во всех объявлениях */
        $this->createTable('ad_main', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),           // Пользователь, который добавил объявление (обязательно). Связь с таблицей user
            'place_city_id' => $this->integer(),     // Город, для которого добавлено объявление. Связь с таблицей place_city
            'category_id' => $this->integer()->notNull(),    // Тема объявления. Связь с таблицей ad_category
            'ad_style_id' => $this->integer()->defaultValue(1),       // Стиль объявления. Связь с таблицей ad_style
        ]);

        $this->addForeignKey('ad_main_user', 'ad_main', 'user_id', 'user', 'id');
        $this->addForeignKey('ad_main_place_city', 'ad_main', 'place_city_id', 'place_city', 'id');
        $this->addForeignKey('ad_main_category', 'ad_main', 'category_id', 'ad_category', 'id');
        $this->addForeignKey('ad_main_style', 'ad_main', 'ad_style_id', 'ad_style', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('ad_main_place_city', 'ad_main');
        $this->dropForeignKey('ad_main_user', 'ad_main');
        $this->dropTable('ad_main');
        $this->dropForeignKey('ad_category_reference_main', 'ad_category');
        $this->dropTable('ad_category');
        $this->dropTable('ad_reference_main');
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
