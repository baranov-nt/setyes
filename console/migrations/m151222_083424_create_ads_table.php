<?php
use yii\db\Migration;

class m151222_083424_create_ads_table extends Migration
{
    public function safeUp()
    {
        /* Главная страница объявлений */
        $this->createTable('ads', [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer()->notNull(),                                   // Место, к которому привязано объявление
            'price' => $this->money(10,2),                                                 // цена
            'currency' => $this->string(3)->notNull(),                                   // Валюта пользователя, который дал объявление
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
            'real_estate_id' => $this->integer(),                                       // Категория для недвижемости
            'transport_id' => $this->integer(),                                         // Категория для автотранспорта
            'electronics_id' => $this->integer(),                                       // Категория для электроники
            'clothes_id' => $this->integer(),                                           // Категория для одежды
            'work_id' => $this->integer(),                                              // Категория для работы
            'animals_id' => $this->integer(),                                           // Категория для животных
        ]);

        $this->addForeignKey('ads_category', 'ads', 'categoty_id', 'ads_category', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('ads_category', 'ads_category');
        $this->dropTable('ads_category');
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
