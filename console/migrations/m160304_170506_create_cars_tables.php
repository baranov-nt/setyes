<?php

use yii\db\Migration;

class m160304_170506_create_cars_tables extends Migration
{
    public function safeUp()
    {
        /* Марки */
        $this->createTable('car_make', [
            'id_car_make' => $this->primaryKey(),
            'name' => $this->string(255)
        ]);

        /* Модели */
        $this->createTable('car_model', [
            'id_car_model' => $this->primaryKey(),
            'id_car_make' => $this->integer(),
            'name' => $this->string(255)
        ]);

        $this->addForeignKey('car_make_car_model', 'car_model', 'id_car_make', 'car_make', 'id_car_make');

        /* Поколения */
        $this->createTable('car_generation', [
            'id_car_generation' => $this->primaryKey(),
            'name' => $this->string(255),
            'id_car_model' => $this->integer(),
            'year_begin' => $this->string(255),
            'year_end' => $this->string(255),
        ]);

        $this->addForeignKey('car_model_car_generation', 'car_generation', 'id_car_model', 'car_model', 'id_car_model');

        /* Серии */
        $this->createTable('car_serie', [
            'id_car_serie' => $this->primaryKey(),
            'id_car_model' => $this->integer(),
            'name' => $this->string(255),
            'id_car_generation' => $this->integer(),
        ]);

        $this->addForeignKey('car_model_car_serie', 'car_serie', 'id_car_model', 'car_model', 'id_car_model');
        $this->addForeignKey('car_generation_car_serie', 'car_serie', 'id_car_generation', 'car_generation', 'id_car_generation');

        /* Модификации */
        $this->createTable('car_trim', [
            'id_car_trim' => $this->primaryKey(),
            'id_car_serie' => $this->integer(),
            'id_car_model' => $this->integer(),
            'name' => $this->string(255),
            'start_production_year' => $this->integer(),
            'end_production_year' => $this->integer(),
            'price_min' => $this->integer(),
            'price_max' => $this->integer(),
        ]);

        $this->addForeignKey('car_serie_car_trim', 'car_trim', 'id_car_serie', 'car_serie', 'id_car_serie');
        $this->addForeignKey('car_model_car_trim', 'car_trim', 'id_car_model', 'car_model', 'id_car_model');

        /* Значения характеристик */
        $this->createTable('car_specification_value', [
            'id_car_specification_value' => $this->primaryKey(),
            'value' => $this->string(255),
            'unit' => $this->string(255),
            'id_car_specification' => $this->integer(),
            'id_car_trim' => $this->integer(),
        ]);

        $this->addForeignKey('car_trim_car_specification_value', 'car_specification_value', 'id_car_trim', 'car_trim', 'id_car_trim');

        /* Характеристики */
        $this->createTable('car_specification', [
            'id_car_specification' => $this->primaryKey(),
            'name' => $this->string(255),
            'id_parent' => $this->integer(),
        ]);

        $this->addForeignKey('car_specification_car_specification_value', 'car_specification_value', 'id_car_specification', 'car_specification', 'id_car_specification');
    }

    public function safeDown()
    {
        echo "m160304_170506_create_cars_tables cannot be reverted.\n";

        return false;
    }
}
