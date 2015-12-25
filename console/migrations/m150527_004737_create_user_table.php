<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_004737_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'phone' => Schema::TYPE_STRING.'(32) NOT NULL UNIQUE',
            'email' => Schema::TYPE_STRING.' NOT NULL UNIQUE',
            'password_hash' => Schema::TYPE_STRING.' NOT NULL',
            'status' => Schema::TYPE_SMALLINT.' NOT NULL',
            'premium' => Schema::TYPE_BOOLEAN,                                  // флаг для премиум пользователя
            'country_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'auth_key' => Schema::TYPE_STRING.'(32) NOT NULL',
            'secret_key' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER.' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER.' NOT NULL',
        ]);

        /* Таблица для сделок категории комнаты */
        $this->createTable('premium', [
            'user_id' => $this->primaryKey(),
            'images_num' => $this->smallInteger()->defaultValue(5),               // количество изображений по умолчанию
            'phones' => $this->smallInteger()->defaultValue(1),                   // количество телефонов по умолчанию
            'vip_style' => $this->boolean()->defaultValue(false),                 // доступ к дополнительным стилям
        ]);

        $this->addForeignKey('premium_user', 'premium', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('user');
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
