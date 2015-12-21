<?php

use yii\db\Schema;
use yii\db\Migration;

class m151221_104037_create_ads_tables extends Migration
{
    public function safeUp()
    {
        /* Главная страница объявлений */
        $this->createTable('ads', [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer()->notNull(),                                   // Место, к которому привязано объявление
            'user_id' => $this->integer()->notNull(),                                    // Пользователь, который добавил объявление
            'style_id' => $this->integer()->notNull()->defaultValue(1),                  // Стиль для объявления (по умолчанию 1)
            'categoty_id' => $this->integer()->notNull(),                                // Категория объявления
            'created_at' => $this->integer()->notNull(),                                 // Дата создания объявления
            'updated_at' => $this->integer()->notNull(),                                 // Дата изменения объявления
        ]);

        $this->addForeignKey('ads_place', 'ads', 'place_id', 'place', 'id', 'CASCADE');
        $this->addForeignKey('ads_user', 'ads', 'user_id', 'user', 'id', 'CASCADE');

        /* Таблица стилей объявлений */
        $this->createTable('ads_style', [
            'id' => $this->primaryKey(),
            'background_color' => $this->string(7),                                     // Цвет фона объявления
            'border_color' => $this->string(7),                                         // Цвет рамки объявления
            'font_family' => $this->string(32),                                         // Фрифт для объявления
            'font_style' => $this->string(32),                                          // Стиль шрифта (курсив, ширный, обычный) объявления
            'font_color' => $this->string(7),                                           // Цвет шрифта объявления
        ]);

        $this->addForeignKey('ads_style', 'ads', 'style_id', 'ads_style', 'id', 'CASCADE');

        $this->batchInsert('ads_style', ['id', 'background_color', 'border_color', 'font_family', 'font_style', 'font_color'],
            [
                [1, '#ffffff', '#000000', '', '', '#000000']
            ]);

        /* Таблица категорий объявлений (от этой таблицы идут связи к подробным данным конкретных объявлений) */
        $this->createTable('ads_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32),                                                // Название категории
            'real_estate_id' => $this->integer(),                                       // Категория для недвижемости
            'cars_id' => $this->integer(),                                              // Категория для автотранспорта
            'dress_id' => $this->integer(),                                             // Категория для одежды
            'work_id' => $this->integer(),                                              // Категория для работы
            'animals_id' => $this->integer(),                                           // Категория для животных
            'electronics_id' => $this->integer(),                                       // Категория для электроники
        ]);

        $this->addForeignKey('ads_category', 'ads', 'categoty_id', 'ads_category', 'id', 'CASCADE');

        /* Таблица для категории - недвижемость */
        $this->createTable('real_estate', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),                                   // Тип нежвижемости (квартира, дом, вилла и т.д.), таблица reference
            'deal_id' => $this->integer()->notNull(),                                   // Тип сделки с нежвижемостью (сдать, продать, купить и т.д.), таблица reference
            'area_id' => $this->integer(),                                              // Площадь недвижемости (м2, футы2) area_real_estate

        ]);
    }



    public function safeDown()
    {
        $this->dropForeignKey('ads_style', 'ads_style');
        $this->dropTable('ads_style');
        $this->dropForeignKey('ads_user', 'ads');
        $this->dropTable('ads');
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
