<?php
use yii\db\Migration;

class m151222_122333_create_real_estate_table extends Migration
{
    public function safeUp()
    {
        /* Таблица категорий объявлений недвижемости */
        $this->createTable('ads_real_estate', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),                                          // Категория для комнат
            'apartament_id' => $this->integer(),                                    // Категория для квартир
            'house_id' => $this->integer(),                                        // Категория для домов и коттеджей
            'land_plot_id' => $this->integer(),                                    // Категория для земельных участков
            'garage_id' => $this->integer(),                                       // Категория для гаражей
            'commercial_property_id' => $this->integer(),                          // Категория для коммерческой недвижемости
        ]);

        $this->addForeignKey('ads_category_real_estate', 'ads_category', 'real_estate_id', 'ads_real_estate', 'id', 'CASCADE');

        /* Таблица для сделок категории комнаты */
        $this->createTable('ads_room', [
            'id' => $this->primaryKey(),
            'type_deal' => $this->integer(),                                        // Сделка с недвижемостью (Снять, сдать, купить, продать), с таблице reference
        ]);

        $this->addForeignKey('ads_room_reference', 'ads_room', 'type_deal', 'reference', 'id');

    }

    public function safeDown()
    {
        $this->dropForeignKey('ads_category_real_estate', 'ads_real_estate');
        $this->dropTable('ads_real_estate');
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
