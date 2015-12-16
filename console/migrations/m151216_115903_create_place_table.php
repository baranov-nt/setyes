<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_115903_create_place_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('place', [
            'id' => Schema::TYPE_PK,
            'place_id' => Schema::TYPE_STRING.'(32) NOT NULL',
            'country_id' => Schema::TYPE_STRING.'(32) NOT NULL',
        ]);
        $this->createTable('country', [
            'place_id' => Schema::TYPE_PK,
            'country_en_name' => Schema::TYPE_STRING.'(2) NOT NULL',
            'country_original_name' => Schema::TYPE_STRING.'(32) NOT NULL',
            'country_short_name' => Schema::TYPE_STRING.'(2) NOT NULL',
            'phone_code' => Schema::TYPE_STRING.'(32) NOT NULL',
            'phone_number_digits' => Schema::TYPE_STRING.'(32) NOT NULL',
        ]);

        $this->addForeignKey('country_place', 'country', 'place_id', 'place', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('country_place', 'country');
        $this->dropTable('country');
        $this->dropTable('place');
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
