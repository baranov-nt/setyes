<?php

/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 11:32
 */

namespace common\widgets\AdWidget;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Url;

class AdWidget extends Widget
{
    public $model;
    public $template;
    public $id;
    public $main_container_class;
    public $favorite_icon;
    public $header;
    public $address;
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
        $items = '';
        if(count($this->images) > 1):
            foreach($this->images as $one):
                $items[] = [
                    'content' => Html::img('/images/'.$one->image->path_small_image, [
                        'style' => 'width: 100%; border-radius: 3px;'
                    ]),
                    'options' => [

                    ],
                    'active' => false
                ];
            endforeach;
        else:
            /* Если одно изоражение */
            foreach($this->images as $one):
                $this->images =  Html::img('/images/'.$one->image->path_small_image, [
                    'style' => 'width: 100%'
                ]);
            endforeach;
        endif;

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
