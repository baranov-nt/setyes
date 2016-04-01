<?php
namespace backend\models;

use common\models\User;

/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 31.03.2016
 * Time: 20:52
 */
class RedisModel extends \yii\redis\ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return ['id', 'name', 'address', 'registration_date'];
    }

    /**
     * @return ActiveQuery defines a relation to the Order record (can be in other database, e.g. elasticsearch or sql)
     */
    public function getOrders()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public function active($query)
    {
        $query->andWhere(['status' => 10]);
    }
}