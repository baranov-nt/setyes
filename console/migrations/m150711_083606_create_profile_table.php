<?php

use yii\db\Schema;
use yii\db\Migration;

class m150711_083606_create_profile_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'user_profile',
            [
                'user_id' => Schema::TYPE_PK,
                'images_num' => $this->smallInteger()->defaultValue(1),
                'images_label' => $this->smallInteger(2)->defaultValue(99),
                'first_name' => Schema::TYPE_STRING.'(32)',
                'second_name' => Schema::TYPE_STRING.'(32)',
                'middle_name' => Schema::TYPE_STRING.'(32)',
                'the_second_phone' => Schema::TYPE_INTEGER.'(11) NULL',
                'the_third_phone' => Schema::TYPE_INTEGER.'(11) NULL',
                'birthday' => Schema::TYPE_INTEGER,
                'gender' => Schema::TYPE_SMALLINT
            ]
        );
        $this->addForeignKey('profile_user', 'user_profile', 'user_id', 'user', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('profile_user', 'user_profile');
        $this->dropTable('user_profile');
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
