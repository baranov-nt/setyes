<?php
use yii\db\Migration;

class m151222_122333_create_real_estate_table extends Migration
{
    public function safeUp()
    {
        /* Таблица категорий объявлений недвижемости */
        $this->createTable('ads_category_realestate', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),                                          // Категория для комнат
            'apartament_id' => $this->integer(),                                    // Категория для квартир
            'house_id' => $this->integer(),                                        // Категория для домов и коттеджей
            'land_plot_id' => $this->integer(),                                    // Категория для земельных участков
            'garage_id' => $this->integer(),                                       // Категория для гаражей
            'commercial_property_id' => $this->integer(),                          // Категория для коммерческой недвижемости
        ]);

        $this->addForeignKey('realestate_category_ads', 'ads_category', 'realestate_id', 'ads_category_realestate', 'id', 'CASCADE');

        /* Таблица для сделок категории комнаты */
        $this->createTable('ads_category_realestate_room', [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer()->notNull(),                                   // Место, к которому привязано объявление
            'deal_type' => $this->integer(),                                        // Сделка с недвижемостью (Снять, сдать, купить, продать), с таблице reference
            'images_num' => $this->smallInteger()->defaultValue(5),
            'images_label' => $this->string(32)->defaultValue('room'),
            'video' => $this->string(255),
            'area' => $this->integer(),                                             // Значение площади
            'area_type' => $this->integer(),                                        // Аттрибут площади (m2 или ft2) из таблицы reference
            'number_room_type' => $this->integer(),                                 // Количество комнат в квартире (1 - 6)
            'floor_type' => $this->integer(),                                       // Этаж (не первый, не последний, не первый и не последний) из таблицы reference
            'number_floor_type' => $this->integer(),                                // Количество этажей в доме  из таблицы reference
            'house_type' => $this->integer(),                                       // Метериал из которого построено здание (панели, девево и тд.)
            'period_type' => $this->integer(),                                      // Срок сдачи (сутки, месяц) из таблицы reference
            'price' => $this->money(10,2),                                          // цена
            'currency' => $this->string(3)->notNull(),                              // валюта пользователя, который дал объявление
        ]);

        $this->addForeignKey('room_realestate_category_ads', 'ads_category_realestate', 'room_id', 'ads_category_realestate_room', 'id', 'CASCADE');
        $this->addForeignKey('room_place_id_place', 'ads_category_realestate_room', 'place_id', 'place', 'id', 'CASCADE');
        $this->addForeignKey('room_deal_type_reference', 'ads_category_realestate_room', 'deal_type', 'reference', 'id');
        $this->addForeignKey('room_area_type_reference', 'ads_category_realestate_room', 'area_type', 'reference', 'id');
        $this->addForeignKey('room_number_room_type_reference', 'ads_category_realestate_room', 'number_room_type', 'reference', 'id');
        $this->addForeignKey('room_floor_type_reference', 'ads_category_realestate_room', 'floor_type', 'reference', 'id');
        $this->addForeignKey('room_number_floor_type_reference', 'ads_category_realestate_room', 'number_floor_type', 'reference', 'id');
        $this->addForeignKey('room_house_type_reference', 'ads_category_realestate_room', 'house_type', 'reference', 'id');
        $this->addForeignKey('room_period_type_reference', 'ads_category_realestate_room', 'period_type', 'reference', 'id');
    }



    public function safeDown()
    {
        $this->dropForeignKey('room_reference', 'ads_category_realestate_room');
        $this->dropForeignKey('room_realestate_category_ads', 'ads_category_realestate_room');
        $this->dropTable('ads_category_realestate_room');
        $this->dropTable('ads_category_realestate');
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
