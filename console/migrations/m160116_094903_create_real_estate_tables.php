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
                [1, 8, Yii::t('references', 'rooms')],                      // комнаты
                [2, 8, Yii::t('references', 'apartments')],                 // квартиры
                [3, 8, Yii::t('references', 'houses')],                     // дома и коттеджи
                [4, 8, Yii::t('references', 'land plots')],                 // земельные участки
                [5, 8, Yii::t('references', 'garages')],   // гаражи и стоянки
                [6, 8, Yii::t('references', 'commercial property')],            // недвижемость за рубежем
                [7, 0, ''],
                /* Операции с комнатами */
                [8, 1, Yii::t('references', 'selling room')],               // продам комнату
                [9, 1, Yii::t('references', 'rent a room')],                // сдам комнату
                [10, 1, Yii::t('references', 'buy room')],                   // купить комнату
                [11, 1, Yii::t('references', 'renting a room')],            // сниму комнату
                /* Операции с квартирами */
                [12, 2, Yii::t('references', 'selling an apartment')],      // продам квартиру
                [13, 2, Yii::t('references', 'rent an apartment')],         // сдам квартиру
                [14, 2, Yii::t('references', 'buy an apartment')],          // купить квартиру
                [15, 2, Yii::t('references', 'renting an apartment')],      // сниму квартиру
                /* Операции с домами */
                [16, 3, Yii::t('references', 'selling a house')],      // продам дом
                [17, 3, Yii::t('references', 'rent a house')],         // сдам дом
                [18, 3, Yii::t('references', 'buy a house')],          // купить дом
                [19, 3, Yii::t('references', 'renting a house')],      // сниму дом
                /* Операции с земельными участками */
                [20, 4, Yii::t('references', 'selling land')],              // продам земельный участок
                [21, 4, Yii::t('references', 'buy plot')],                  // куплю земельный участок
                /* Операции с гаражами */
                [22, 5, Yii::t('references', 'selling garage')],        // продам гараж
                [23, 5, Yii::t('references', 'rent garage')],           // сдам гараж
                [24, 5, Yii::t('references', 'buy garage')],            // купить гараж
                [25, 5, Yii::t('references', 'looking for garage')],    // ищу гараж
                /* Операции с недвижемостью за рубежем */
                [26, 0, ''],        // продам недвижемость за рубежем
                [27, 0, ''],           // сдам недвижемость за рубежем
                /* Операции с коммерческой недвижемостью */
                [28, 6, Yii::t('references', 'selling commercial property')],        // продам коммерческую недвижемость
                [29, 6, Yii::t('references', 'rent commercial property')],           // сдам коммерческую недвижемость
                [30, 6, Yii::t('references', 'buy commercial property')],            // купить коммерческую недвижемость
                [31, 6, Yii::t('references', 'renting commercial property')],        // сниму коммерческую недвижемость
                /* Количество комнат в квартире (для типа недвижимости комнаты) */
                [32, 9, 1],
                [33, 9, 2],
                [34, 9, 3],
                [35, 9, 4],
                [36, 9, 5],
                [37, 9, 6],
                [38, 9, Yii::t('references', 'more than 6')],
                /* Состояние недвижемости */
                [39, 25, Yii::t('references', 'requires repair')],             // требуется ремонт
                [40, 25, Yii::t('references', 'normal')],                      // нормальное
                [41, 25, Yii::t('references', 'excellent')],                   // не доступна
                /* Этаж */
                [43, 11, Yii::t('references', 'basement')],
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
                [78, 13, Yii::t('references', 'for a short time')],                     // посуточно
                /* Цена за */
                [79, 14, Yii::t('references', 'price for a day')],              // день
                [80, 14, Yii::t('references', 'price per month')],              // месяц
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
                [89, 16, Yii::t('references', 'residential building')],              // перепродажа
                [90, 16, Yii::t('references', 'new building')],        // новое здание
                /* Единицы измерения площади земли */
                [91, 28, Yii::t('references', 'ar (a)')],               // сотка
                [92, 28, Yii::t('references', 'hectare (ha)')],         // гектар
                [93, 29, Yii::t('references', 'acre')],                 // акр
                [94, 29, Yii::t('references', 'mile²')],                // миля
                /* Тип земельного участка */
                [95, 18, Yii::t('references', 'land settlements')],     // земли населенных пунктов
                [96, 18, Yii::t('references', 'industrial land')],      // Промышленные земли
                [97, 18, Yii::t('references', 'farmland')],             // сельскохозяйственные земли
                /* Тип гаража */
                [98, 0, ''],
                [99, 0, ''],
                /* Тип недвижимости за рубежем */
                [100, 0, ''],
                [101, 0, ''],
                /* Тип коммерческой недвижимости */
                [102, 21, Yii::t('references', 'cafe, restaurant')],        // кафе, ресторан
                [103, 21, Yii::t('references', 'shop')],                    // магазин
                [104, 21, Yii::t('references', 'office')],                  // офис
                [105, 21, Yii::t('references', 'production')],              // производство
                [106, 21, Yii::t('references', 'warehouse')],               // склад
                [107, 21, Yii::t('references', 'building a free appointment')],    // строение свободного назначения
                /* Площадь для земельных участков */
                [108, 22, Yii::t('references', 'acre')],                 // акр
                [109, 22, Yii::t('references', 'hectare')],              // гектар
                /* Необходимая мебель */
                [110, 23, Yii::t('references', 'there is')],            // доступна
                [111, 23, Yii::t('references', 'there is not')],        // не доступна
                /* Метериал строения */
                [112, 24, Yii::t('references', 'modular')],           // модульное
                [113, 24, Yii::t('references', 'wood')],              // деревянное
                [114, 24, Yii::t('references', 'brick')],             // кирпичное
                [115, 24, Yii::t('references', 'cinder block or other blocks')],             // блоки
                [116, 24, Yii::t('references', 'monolithic')],        // монолитное
                [117, 24, Yii::t('references', 'panel')],             // панельное
                /* Бытовая техника */
                [118, 26, Yii::t('references', 'computer')],                    // компьютер
                [119, 26, Yii::t('references', 'washing machine')],             // стиральная машина
                [120, 26, Yii::t('references', 'air conditioning')],            // кондиционер
                [121, 26, Yii::t('references', 'microwave oven')],              // микроволновая печь
                [122, 26, Yii::t('references', 'electric or gas cooker')],      // электро или газовая плита
                [123, 26, Yii::t('references', 'refrigerator')],                // холодильник
                [124, 26, Yii::t('references', 'TV')],                          // телевизор
                /* Домашние животные разрешены */
                [125, 27, Yii::t('references', 'Yes')],                // да
                [126, 27, Yii::t('references', 'No')],                 // нет
                /* Интернет */
                [127, 10, Yii::t('references', 'available')],            // доступна
                [128, 10, Yii::t('references', 'not available')],        // не доступна
                /* Тип недвижимости (перепродажа, New building) для коттеджей */
                [129, 17, Yii::t('references', 'summer house')],        // летний дом (сад)
                [130, 17, Yii::t('references', 'country house')],        // деревенский дом
                [131, 17, Yii::t('references', 'cottage')],              // коттедж
                [132, 17, Yii::t('references', 'villa')],                // дом
                /* Свободные 20, 30, (id 7, 26, 27, 100, 101, 98, 99) */
            ]);

        /* Создаем таблицу  ad_real_estate, в которой будут храниться объявления категории “Недвижимость” */
        $this->createTable('ad_real_estate', [
            'id' => $this->primaryKey(),
            'property' => $this->integer()->notNull(),           // Недвижимость (комната, дом, квартира). Связана с таблицей ad_real_estate_reference
            'deal_type' => $this->integer()->notNull(),          // Тип операции. Связана с таблицей ad_real_estate_reference
            'type_of_property' => $this->integer(),             // Тип недвижимости .для квартир - 16, для домов - 17, для гаража - 19, для недвижемости за границей - 20, для коммерческой недвижимости - 21  Связана с таблицей ad_real_estate_reference
            'place_address_id' => $this->integer(),             // Адрес для которого добавлено объявление. Связь с таблицей place_address
            'rooms_in_the_apartment' => $this->integer(),        // Количество комнат в квартире. Если тип недвижимости комнаты, используем reference = 9, если квартиры, reference = 15. Связана с таблицей ad_real_estate_reference
            'material_housing' => $this->integer(),              // Материал строения - 24. Связана с таблицей ad_real_estate_reference
            'floor' => $this->integer(),                         // Этаж. Связана с таблицей ad_real_estate_reference
            'floors_in_the_house' => $this->integer(),           // Количество этажей в здании. Используем reference этажей. Связана с таблицей ad_real_estate_reference
            'area_of_property' => $this->integer(),              // Площадь помещения
            'measurement_of_property' => $this->integer(),       // Единицы измерения площади недвижемости (м2 или фут квадратный)
            'area_of_land' => $this->integer(),                  // Площадь земли
            'measurement_of_land' => $this->integer(),           // Единицы измерения площади земли (сотки или гектары)
            'lease_term' => $this->integer(),                    // Срок аденды. Связана с таблицей ad_real_estate_reference
            'price' => $this->integer(),                        // Цена
            'price_for_the_period' => $this->integer(),          // Цена за - 14. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'necessary_furniture' => $this->integer(),           // меблированный  (есть, нет) - 23. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'internet' => $this->integer(),                      // Наличие интернета (есть, нет) - 10. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'pets_allowed' => $this->integer(),                  // Домашние животные разрешены - 27
            'condition' => $this->integer(),                     // Состояние (есть, нет) - 25. Зависит от значения lease_term. Связана с таблицей ad_real_estate_reference
            'images_label' => $this->smallInteger(2)->defaultValue(1), // метка изображения (1 - для недвижимости)
            'video_link' => $this->string(),                    // ссылка для видео
            'model_scenario' => $this->string(255),             // использованный сценарий для создания записи
        ]);

        //$this->addforeignKey('ad_real_estate_category', 'ad_category', 'ad_id', 'ad_real_estate', 'id');
        $this->addforeignKey('ad_real_estate_property_reference', 'ad_real_estate', 'property', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_type_of_property_reference', 'ad_real_estate', 'type_of_property', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_deal_type_reference', 'ad_real_estate', 'deal_type', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_place_address', 'ad_real_estate', 'place_address_id', 'place_address', 'id');
        $this->addforeignKey('ad_real_estate_rooms_in_the_apartment_reference', 'ad_real_estate', 'rooms_in_the_apartment', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_material_housing_reference', 'ad_real_estate', 'material_housing', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_floor_reference', 'ad_real_estate', 'floor', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_floors_in_the_house_reference', 'ad_real_estate', 'floors_in_the_house', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_measurement_of_property_reference', 'ad_real_estate', 'measurement_of_property', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_measurement_of_land_reference', 'ad_real_estate', 'measurement_of_land', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_lease_term_reference', 'ad_real_estate', 'lease_term', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_price_for_the_period_reference', 'ad_real_estate', 'price_for_the_period', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_necessary_furniture_reference', 'ad_real_estate', 'necessary_furniture', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_internet_reference', 'ad_real_estate', 'internet', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_pets_allowed_reference', 'ad_real_estate', 'pets_allowed', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_condition_reference', 'ad_real_estate', 'condition', 'ad_real_estate_reference', 'id');

        $this->createTable('ad_real_estate_appliances', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),                   // Номер справочного раздела
            'real_estate_id' => $this->integer()->notNull(),                 // Номер объявления
        ]);

        $this->addforeignKey('ad_real_estate_reference_id', 'ad_real_estate_appliances', 'reference_id', 'ad_real_estate_reference', 'id');
        $this->addforeignKey('ad_real_estate_id', 'ad_real_estate_appliances', 'real_estate_id', 'ad_real_estate', 'id');
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
