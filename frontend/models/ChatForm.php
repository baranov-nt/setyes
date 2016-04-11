<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2016
 * Time: 13:06
 */

namespace frontend\models;

use Yii;
use yii\base\Model;

class ChatForm extends Model
{
    public $name;
    public $message;

    public function rules()
    {
        return [
            [['name', 'message'], 'required'],
            [['name', 'message'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'message' => 'Сообщение',
        ];
    }
}
