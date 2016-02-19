<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 18.02.2016
 * Time: 23:25
 */
namespace common\widgets\ShowMapModal;

use yii\base\Widget;

class ShowMapModal extends Widget
{
    public $address;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            'map',
            [
                'widget' => $this,
            ]);
    }
}
