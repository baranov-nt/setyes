<?php

use yii\db\Migration;

class m151222_013751_create_reference_table extends Migration
{
    public function safeUp()
    {
        /* Справочная таблица */
        $this->createTable('reference', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),                                        // Номер раздела
            'name' => $this->string(64),                                            // Название элемента
        ]);

        $this->batchInsert('reference', ['type', 'name'],
            [
                /* Разделы */
                [1, Yii::t('reference', 'Real Estate')],
                [1, Yii::t('reference', 'Cars, Truck, Motocycle')],
                [1, Yii::t('reference', 'Electronics')],
                [1, Yii::t('reference', 'Clothes and Footwear')],
                [1, Yii::t('reference', 'Work')],
                [1, Yii::t('reference', 'Animals')],
                /* Единицы измерения длинны (метрические) */
                [2, Yii::t('reference', 'm')],                                      // метр
                /* Единицы измерения площади (метрические) */
                [3, Yii::t('reference', 'm²')],                                      // метр
                /* Единицы измерения длинны (не метрические) */
                [5, Yii::t('reference', 'foot')],                                  // фут = 0,3048 м
                /* Единицы измерения площади (не метрические) */
                [6, Yii::t('reference', 'foot²')],                                  // фут² = 929,03 см²
                /* Возможные сделки с недвижемостью */
                [7, Yii::t('reference', 'Selling property')],                      // продажа недвижемости
                [7, Yii::t('reference', 'Rent property')],                      // сдам недвижимость
                [7, Yii::t('reference', 'Buy property')],                      // покупка недвижимости
                [7, Yii::t('reference', 'Renting an apartment')],              // сниму недвижимость
                /* Этаж недвижемости */
                [8, Yii::t('reference', 'not first')],                          // не первый
                [8, Yii::t('reference', 'not last')],                           // не последний
                [8, Yii::t('reference', 'not the first nor the last')],         // не первый и не последний
                /* Количество комнат в квартире */
                [9, Yii::t('reference', '1')],
                [9, Yii::t('reference', '2')],
                [9, Yii::t('reference', '3')],
                [9, Yii::t('reference', '4')],
                [9, Yii::t('reference', '5')],
                [9, Yii::t('reference', '6')],
                [9, Yii::t('reference', 'more than 6')],
                /* Количество этажей в доме */
                [10, Yii::t('reference', 'less than 5')],
                [10, Yii::t('reference', '5-8')],
                [10, Yii::t('reference', '9-12')],
                [10, Yii::t('reference', '13-18')],
                [10, Yii::t('reference', '19-25')],
                [10, Yii::t('reference', 'more than 25')],
                /* Тип жилья */
                [11, Yii::t('reference', 'resale')],
                [11, Yii::t('reference', 'new building')],
                /* Срок сдачи за указанную сумму (сутки, месяц) */
                [12, Yii::t('reference', 'per day')],
                [12, Yii::t('reference', 'per month')],
            ]);
    }

    public function safeDown()
    {
        $this->dropTable('reference');
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
