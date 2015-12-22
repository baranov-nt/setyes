<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_013751_create_reference_table extends Migration
{
    public function safeUp()
    {
        /* Справочная таблица */
        $this->createTable('reference', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger(),                                    // Номер раздела
            'name' => $this->string(7),                                         // Название элемента
        ]);

        $this->batchInsert('reference', ['type', 'name'],
            [
                /* Валюта */
                [1, Yii::t('reference', 'USD')],
                [1, Yii::t('reference', 'EUR')],
                [1, Yii::t('reference', 'RUB')],
                /* Разделы */
                [2, Yii::t('reference', 'Real Estate')],
                [2, Yii::t('reference', 'Cars, Truck, Motocycle')],
                [2, Yii::t('reference', 'Electronics')],
                [2, Yii::t('reference', 'Clothes and Footwear')],
                [2, Yii::t('reference', 'Work')],
                [2, Yii::t('reference', 'Animals')],
                /* Единицы измерения площади */
                [3, Yii::t('reference', 'm2')],
                [3, Yii::t('reference', 'ft2')],
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
