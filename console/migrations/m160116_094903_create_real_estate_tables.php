<?php

use yii\db\Schema;
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
                [28, 5, Yii::t('references', 'Selling property')],        // продам коммерческую недвижемость
                [29, 5, Yii::t('references', 'Rent property')],           // сдам коммерческую недвижемость
                [30, 5, Yii::t('references', 'Buy property')],            // купить коммерческую недвижемость
                [31, 5, Yii::t('references', 'Renting property')],        // сниму коммерческую недвижемость
            ]);

        /* Создаем таблицу  ad_real_estate, в которой будут храниться объявления категории “Недвижимость” */
        $this->createTable('ad_real_estate', [
            'id' => $this->primaryKey(),
            'property_type' => $this->integer()->notNull(),                 // Тип недвижимости. Связана с таблицей ad_real_estate_reference
            'operation_type' => $this->integer()->notNull(),                // Тип операции. Связана с таблицей ad_real_estate_reference
        ]);

        $this->addForeignKey('ad_real_estate_property_type_reference', 'ad_real_estate', 'property_type', 'ad_real_estate_reference', 'id');
        $this->addForeignKey('ad_real_estate_operation_type_reference', 'ad_real_estate', 'operation_type', 'ad_real_estate_reference', 'id');
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
