<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_004737_create_user_table extends Migration
{
    public function up()
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
    }

    public function down()
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
