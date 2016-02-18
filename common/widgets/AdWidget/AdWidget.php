<?php

/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 11:32
 */

namespace common\widgets\AdWidget;

use common\models\AdMain;
use Yii;
use yii\base\Widget;

class AdWidget extends Widget
{
    public $model;
    public $template;
    public $id;
    public $author;
    public $main_container_class;
    public $favorite;
    public $favorite_icon;
    public $header;
    public $address;
    public $address_map;
    public $phone_temp_ad;
    public $images;
    public $content;
    public $quick_view_class;

    public function init()
    {
        parent::init();
        $this->registerClientScript();
    }

    public function run()
    {
        $modelAdMain = new AdMain();
        $items = $modelAdMain->getSmallImagesList($this->images);

        return $this->render(
            'view',
            [
                'widget' => $this,
                'items' => $items,
                'user' => $user = Yii::$app->user->identity
            ]);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        $js = <<<JS
        $("#id_$this->id").on("pjax:complete", function() {
            $("#id_$this->id").attr("tabindex",-1).focus();
         });
JS;
        $view->registerJS($js);
    }
}
