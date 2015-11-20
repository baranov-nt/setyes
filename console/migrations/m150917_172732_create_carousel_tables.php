<?php

use yii\db\Migration;

class m150917_172732_create_carousel_tables extends Migration
{
    /*public function up()
    {

    }

    public function down()
    {
        echo "m150917_172732_create_image_category_carousel_product_tables cannot be reverted.\n";

        return false;
    }*/


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('carousel', [                    // таблица для карусели на главной странице
            'id' => $this->primaryKey(),
            'images_num' => $this->smallInteger()->defaultValue(1),
            'images_label' => $this->string(32)->defaultValue('carousel'),
            'header' => $this->string(255),                 // название заголовка
            'content' => $this->string(255),                // контент
            'product_id' => $this->integer(),               // id соответствующего товара (если есть, то формируем ссылку на товар)
            'user_id' => $this->integer()->notNull(),       // id пользователя который добавил элемент карусели
            'temp' => $this->boolean()->defaultValue('1'),                     // временная запись или нет
        ]);

        $this->addForeignKey('carousel_user', 'carousel', 'user_id', 'user', 'id');             // связь таблицы carousel с таблицей product
    }

    public function safeDown()
    {
        $this->dropForeignKey('carousel_user', 'carousel');
        $this->dropTable('carousel');
    }
}
