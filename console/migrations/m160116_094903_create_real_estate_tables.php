<?php

use yii\db\Migration;

class m160116_094903_create_real_estate_tables extends Migration
{
    public function safeUp()
    {
        /* Создаем таблицу  ad_reference_real_estate, в которой будут хранится основные свойства объявлений категории недвижимости */
        $this->createTable('ad_real_estate_reference', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),              // Номер справочного раздела
            'reference_name' => $this->string()->notNull(),             // Название элемента
        ]);

        /* Добавляем основные свойства */
        $this->batchInsert('ad_real_estate_reference', ['id', 'reference_id', 'reference_name'],
            [
                /* Тип недвижимости */
                [1, 8, Yii::t('references', 'Rooms')],                      // комнаты
                [2, 8, Yii::t('references', 'Apartments')],                 // квартиры
                [3, 8, Yii::t('references', 'Houses & cottages')],          // дома и коттеджи
                [4, 8, Yii::t('references', 'Land plots')],                 // земельные участки
                [5, 8, Yii::t('references', 'Garages and parking lots')],   // гаражи и стоянки
                [6, 8, Yii::t('references', 'Property Abroad')],            // недвижемость за рубежем
                [7, 8, Yii::t('references', 'Commercial Property')],        // коммерческая недвижемость
                /* Операции с комнатами */
                [8, 1, Yii::t('references', 'Selling room')],               // продам комнату
                [9, 1, Yii::t('references', 'Rent a room')],                // сдам комнату
                [10, 1, Yii::t('references', 'Buy room')],                   // купить комнату
                [11, 1, Yii::t('references', 'Renting a room')],            // сниму комнату
                /* Операции с квартирами */
                [12, 2, Yii::t('references', 'Selling an apartment')],      // продам квартиру
                [13, 2, Yii::t('references', 'Rent an apartment')],         // сдам квартиру
                [14, 2, Yii::t('references', 'Buy an apartment')],          // купить квартиру
                [15, 2, Yii::t('references', 'Renting an apartment')],      // сниму квартиру
                /* Операции с домами */
                [16, 3, Yii::t('references', 'Selling a house, villa')],      // продам дом
                [17, 3, Yii::t('references', 'Rent a house, villa')],         // сдам дом
                [18, 3, Yii::t('references', 'Buy a house, villa')],          // купить дом
                [19, 3, Yii::t('references', 'Renting a house, villa')],      // сниму дом
                /* Операции с земельными участками */
                [20, 4, Yii::t('references', 'Selling land')],              // продам земельный участок
                [21, 4, Yii::t('references', 'Buy plot')],                  // куплю земельный участок
                /* Операции с гаражами */
                [22, 5, Yii::t('references', 'Selling garage')],        // продам гараж
                [23, 5, Yii::t('references', 'Rent garage')],           // сдам гараж
                [24, 5, Yii::t('references', 'Buy garage')],            // купить гараж
                [25, 5, Yii::t('references', 'Looking for garage')],    // ищу гараж
                /* Операции с недвижемостью за рубежем */
                [26, 6, Yii::t('references', 'Selling overseas property')],        // продам недвижемость за рубежем
                [27, 6, Yii::t('references', 'Rent overseas property')],           // сдам недвижемость за рубежем
                /* Операции с коммерческой недвижемостью */
                [28, 7, Yii::t('references', 'Selling property')],        // продам коммерческую недвижемость
                [29, 7, Yii::t('references', 'Rent property')],           // сдам коммерческую недвижемость
                [30, 7, Yii::t('references', 'Buy property')],            // купить коммерческую недвижемость
                [31, 7, Yii::t('references', 'Renting property')],        // сниму коммерческую недвижемость
                /* Количество комнат в квартире (для типа недвижимости комнаты) */
                [32, 9, 1],
                [33, 9, 2],
                [34, 9, 3],
                [35, 9, 4],
                [36, 9, 5],
                [37, 9, 6],
                [38, 9, Yii::t('references', 'more than 6 rooms')],
                /* Метериал строения */
                [39, 10, Yii::t('references', 'modular')],           // модульное
                [40, 10, Yii::t('references', 'wood')],              // деревянное
                [41, 10, Yii::t('references', 'brick')],             // кирпичное
                [42, 10, Yii::t('references', 'monolithic')],        // монолитное
                [43, 10, Yii::t('references', 'panel')],             // панельное
                /* Этаж */
                [44, 11, 1],
                [45, 11, 2],
                [46, 11, 3],
                [47, 11, 4],
                [48, 11, 5],
                [49, 11, 6],
                [50, 11, 7],
                [51, 11, 8],
                [52, 11, 9],
                [53, 11, 10],
                [54, 11, 11],
                [55, 11, 12],
                [56, 11, 13],
                [57, 11, 14],
                [58, 11, 15],
                [59, 11, 16],
                [60, 11, 17],
                [61, 11, 18],
                [62, 11, 19],
                [63, 11, 20],
                [64, 11, 21],
                [65, 11, 22],
                [66, 11, 23],
                [67, 11, 24],
                [68, 11, 25],
                [69, 11, 26],
                [70, 11, 27],
                [71, 11, 28],
                [72, 11, 29],
                [73, 11, 30],
                [74, 11, Yii::t('references', 'more than 30')],
                /* Площадь записана в следующей ед. измерения */
                [75, 12, Yii::t('references', 'm²')],                           // метры квадратные
                [76, 12, Yii::t('references', 'ft²')],                          // футы квадратные
                /* Срок аренды */
                [77, 13, Yii::t('references', 'for a long time')],              // долгосрочная
                [78, 13, Yii::t('references', 'for rent')],                     // посуточно
                /* Цена за */
                [79, 14, Yii::t('references', 'Price for a day')],              // день
                [80, 14, Yii::t('references', 'Price per month')],              // месяц
                /* Количество комнат в квартире (для типа недвижимости квартиры) */
                [81, 15, Yii::t('references', 'studio')],
                [82, 15, Yii::t('references', '1 room')],
                [83, 15, Yii::t('references', '2 rooms')],
                [84, 15, Yii::t('references', '3 rooms')],
                [85, 15, Yii::t('references', '4 rooms')],
                [86, 15, Yii::t('references', '5 rooms')],
                [87, 15, Yii::t('references', '6 rooms')],
                [88, 15, Yii::t('references', 'more than 6 rooms')],
                /* Тип недвижимости (перепродажа, New building) для квартир */
                [89, 16, Yii::t('references', 'Resale')],              // перепродажа
                [90, 16, Yii::t('references', 'New building')],        // новое здание
                /* Тип недвижимости (перепродажа, New building) для коттеджей */
                [91, 17, Yii::t('references', 'House')],                // дом
                [92, 17, Yii::t('references', 'Country house')],        // деревенский дом
                [93, 17, Yii::t('references', 'Cottage')],              // коттедж
                [94, 17, Yii::t('references', 'Townhouse')],            // малоэтажный дом на несколько квартир
                /* Тип земельного участка */
                [95, 18, Yii::t('references', 'Land settlements')],     // земли населенных пунктов
                [96, 18, Yii::t('references', 'Industrial land')],      // Промышленные земли
                [97, 18, Yii::t('references', 'Farmland')],             // сельскохозяйственные земли
                /* Тип гаража */
                [98, 19, Yii::t('references', 'Garage')],               // гараж
                [99, 19, Yii::t('references', 'Parking place')],        // парковочное место
                /* Тип недвижимости за рубежем */
                [100, 20, Yii::t('references', 'Houses and villas')],    // дом и вилла
                [101, 20, Yii::t('references', 'Apartments')],           // квартира
                /* Тип коммерческой недвижимости */
                [102, 21, Yii::t('references', 'Cafe, restaurant')],        // кафе, ресторан
                [103, 21, Yii::t('references', 'Shop')],                    // магазин
                [104, 21, Yii::t('references', 'Office')],                  // офис
                [105, 21, Yii::t('references', 'Production')],              // производство
                [106, 21, Yii::t('references', 'Warehouse')],               // склад
                [107, 21, Yii::t('references', 'Building a free appointment')],    // строение свободного назначения
                /* Площадь для земельных участков */
                [108, 22, Yii::t('references', 'acre')],                 // акр
                [109, 22, Yii::t('references', 'hectare')],              // гектар
                /* Необходимая мебель */
                [110, 23, Yii::t('references', 'Furnished')],            // доступна
                [111, 23, Yii::t('references', 'Unfurnished')],        // не доступна
                /* Интернет */
                [112, 24, Yii::t('references', 'Available')],            // доступна
                [113, 24, Yii::t('references', 'Not available')],        // не доступна
                /* Состояние недвижемости */
                [114, 25, Yii::t('references', 'Requires repair')],             // требуется ремонт
                [115, 25, Yii::t('references', 'Normal')],                      // нормальное
                [116, 25, Yii::t('references', 'Excellent')],                   // не доступна
                /* Бытовая техника */
                [117, 26, Yii::t('references', 'TV')],                          // телевизор
                [118, 26, Yii::t('references', 'Сomputer')],                    // компьютер
                [119, 26, Yii::t('references', 'Washing machine')],             // стиральная машина
                [120, 26, Yii::t('references', 'Air conditioning')],            // кондиционер
                [121, 26, Yii::t('references', 'Microwave oven')],              // микроволновая печь
                [122, 26, Yii::t('references', 'Electric or gas cooker')],      // электро или газовая плита
                [123, 26, Yii::t('references', 'Refrigerator')],                // холодильник
            ]);

        /* Создаем таблицу  ad_real_estate, в которой будут храниться объявления категории “Недвижимость” */
        $this->createTable('ad_real_estate', [
            'id' => $this->primaryKey(),
            'property' => $this->integer()->notNull(),                      // Недвижимость (комната, дом, квартира). Связана с таблицей ad_real_estate_reference
            'property_type' => $this->integer()->notNull(),                 // Тип недвижимости .для квартир - 16, для домов - 17, для гаража - 19, для недвижемости за границей - 20, для коммерческой недвижимости - 21  Связана с таблицей ad_real_estate_reference
            'category_land' => $this->integer()->notNull(),                 // Тип земельного участка - 18  Связана с таблицей ad_real_estate_reference
            'operation_type' => $this->integer()->notNull(),                // Тип операции. Связана с таблицей ad_real_estate_reference
            'rooms_in_the_apartment' => $this->integer()->notNull(),        // Количество комнат в квартире. Если тип недвижимости комнаты, используем reference = 9, если квартиры, reference = 15. Связана с таблицей ad_real_estate_reference
            'material_housing' => $this->integer()->notNull(),              // Материал строения. Связана с таблицей ad_real_estate_reference
            'floor' => $this->integer()->notNull(),                         // Этаж. Связана с таблицей ad_real_estate_reference
            'floors_in_the_house' => $this->integer()->notNull(),           // Количество этажей в здании. Используем reference этажей. Связана с таблицей ad_real_estate_reference
            'area' => $this->integer(),                                     // Площадь помещения
            'system_measure' => $this->integer()->notNull(),                // Единица измерения площади 12 - комнат, квартир и домов, 22 - для земли. Связана с таблицей ad_real_estate_reference
            'lease_term' => $this->integer()->notNull(),                    // Срок аденды. Связана с таблицей ad_real_estate_reference
            'price' => $this->integer(),                                    // Цена
            'price_period' => $this->integer()->notNull(),                  // Цена за - 14. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'furnished' => $this->integer()->notNull(),                     // меблированный  (есть, нет) - 23. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'internet' => $this->integer()->notNull(),                      // Наличие интернета (есть, нет) - 24. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'condition' => $this->integer()->notNull(),                      // Наличие интернета (есть, нет) - 25. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
        ]);

        $this->addForeignKey('ad_real_estate_property_reference', 'ad_real_estate', 'property_type', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_property_type_reference', 'ad_real_estate', 'property_type', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_category_land_reference', 'ad_real_estate', 'category_land', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_operation_type_reference', 'ad_real_estate', 'operation_type', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_rooms_in_the_apartment_reference', 'ad_real_estate', 'rooms_in_the_apartment', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_material_housing_reference', 'ad_real_estate', 'material_housing', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_floor_reference', 'ad_real_estate', 'floor', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_floors_in_the_house_reference', 'ad_real_estate', 'floors_in_the_house', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_system_measure_reference', 'ad_real_estate', 'system_measure', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_lease_term_reference', 'ad_real_estate', 'lease_term', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_price_period_reference', 'ad_real_estate', 'price_period', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_furnished_reference', 'ad_real_estate', 'furnished', 'ad_real_estate_reference', 'id');

        /* Создаем таблицу  ad_real_estate_appliances, в которой будет хранится бытовая техника, имеющаяся в квартире. Используется для раздела аренды. */
        $this->createTable('ad_real_estate_appliances', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),                   // Номер справочного раздела
            'real_estate_id' => $this->integer()->notNull(),                 // Номер объявления
        ]);

        $this->addForeignKey('ad_real_estate_reference_id', 'ad_real_estate_appliances', 'reference_id', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_id', 'ad_real_estate_appliances', 'real_estate_id', 'ad_real_estate', 'id');
    }

    public function safeDown()
    {
        echo "m160116_094903_create_real_estate_tables cannot be reverted.\n";

        return false;
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
