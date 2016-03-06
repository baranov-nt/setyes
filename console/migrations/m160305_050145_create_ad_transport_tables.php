<?php

use yii\db\Migration;

class m160305_050145_create_ad_transport_tables extends Migration
{
    public function safeUp()
    {
        /* Создаем таблицу  ad_reference_real_estate, в которой будут хранится основные свойства объявлений категории недвижимости */
        $this->createTable('ad_transport_reference', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),              // Номер справочного раздела
            'reference_name' => $this->string()->notNull(),             // Название элемента
        ]);

        /* Добавляем основные свойства */
        $this->batchInsert('ad_transport_reference', ['id', 'reference_id', 'reference_name'],
            [
                [1, 8, Yii::t('references', 'Passenger car')],
            ]);

        /* Создаем таблицу  ad_transport, в которой будут храниться объявления категории “Транпорт” */
        $this->createTable('ad_transport', [
            'id' => $this->primaryKey(),
            'transport' => $this->integer()->notNull(),                 // Транспорт (легковой, грузовой). Связана с таблицей ad_transport_reference
            'deal_type' => $this->integer()->notNull(),                 // Тип операции. Связана с таблицей ad_transport_reference
            'id_car_model' => $this->integer()->notNull(),              // Модель авто
            'mileage' => $this->integer(),                              // Пробег
            'measurement_of_mileage' => $this->integer(),               // Единицы измерения пробега (километры или мили)
            'price' => $this->integer(),                                // Цена
            'price_for_the_period' => $this->integer(),                 // Цена за
            'equipment' => $this->integer(),                            // комплектация (базовая, стандартная, полная)
            //'car_accessories' => $this->integer(),                      // аксесуары (навигатор, чехол и т.д.)
            'exterior_color' => $this->integer(),                      // цвет кузова
            'interior_color' => $this->integer(),                      // цвет салона
            'condition' => $this->integer(),                            // Состояние
            'images_label' => $this->smallInteger(2)->defaultValue(2),  // метка изображения (2 - для транспорта)
            'video_link' => $this->string(),                            // ссылка для видео
            'model_scenario' => $this->string(255),                     // использованный сценарий для создания записи
        ]);

        $this->addforeignKey('ad_transport_transport_reference', 'ad_transport', 'transport', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_transport_deal_type_reference', 'ad_transport', 'deal_type', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_transport_car_model', 'ad_transport', 'id_car_model', 'car_model', 'id_car_model');
        $this->addforeignKey('ad_transport_measurement_of_mileage_reference', 'ad_transport', 'measurement_of_mileage', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_transport_price_for_the_period_reference', 'ad_transport', 'price_for_the_period', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_equipment_reference', 'ad_transport', 'equipment', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_exterior_color_reference', 'ad_transport', 'exterior_color', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_interior_color_reference', 'ad_transport', 'interior_color', 'ad_transport_reference', 'id');
        $this->addforeignKey('ad_condition_reference', 'ad_transport', 'condition', 'ad_transport_reference', 'id');
    }

    public function down()
    {
        $this->dropTable('ad_transport_tables');
    }
}
