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
