<?php

/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 18:20
 */
namespace common\widgets\Masonry;

use Yii;
use yii\base\Widget;
use common\widgets\Masonry\MasonryAsses;
use yii\web\View;

class Masonry extends Widget
{
    public function init()
    {
        parent::init();
        $this->registerClientScript();
    }

    /*public function run()
    {
        return $this->render(
            'steps',
            [
                'widget' => $this,
            ]);
    }*/

    public function registerClientScript()
    {
        $view = $this->getView();
        // Регистрация виджета
        MasonryAsset::register($view);

        $js = <<< JS
        $(document).ready(function () {
            $('.grid').masonry({
              // options
              itemSelector: '.grid-item'
              //columnWidth: 200
            });
        });
JS;
        $view->registerJs($js);
    }
}
