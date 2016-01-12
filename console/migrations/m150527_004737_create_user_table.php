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
            'balance' => Schema::TYPE_MONEY.'(10,2)',                           // баланс пользователя
            'password_hash' => Schema::TYPE_STRING.' NOT NULL',
            'status' => Schema::TYPE_SMALLINT.' NOT NULL',
            'country_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'auth_key' => Schema::TYPE_STRING.'(32) NOT NULL',
            'secret_key' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER.' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER.' NOT NULL',
        ]);

        /* Таблица для сделок категории комнаты */
        $this->createTable('user_privilege', [
            'user_id' => $this->primaryKey(),
            'premium' => $this->boolean()->defaultValue(false),                    // флаг для премиум пользователя
            'images_num' => $this->smallInteger()->defaultValue(5),               // количество изображений по умолчанию
            'phones' => $this->smallInteger()->defaultValue(1),                   // количество телефонов по умолчанию
            'vip_style' => $this->boolean()->defaultValue(false),                 // доступ к дополнительным стилям
            'time_privilege' => $this->boolean()->defaultValue(false),            // время привелегий (если установлен флаг premium)
        ]);

        $this->addForeignKey('privilege_user', 'user_privilege', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('privilege_user', 'user_privilege');
        $this->dropTable('user_privilege');
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
