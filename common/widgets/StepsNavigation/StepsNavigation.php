<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.02.2016
 * Time: 13:01
 */

namespace common\widgets\StepsNavigation;

use yii\base\Widget;
use common\widgets\StepsNavigation\assets\StepsAsset;
use yii\web\View;
use yii\helpers\Url;

class StepsNavigation extends Widget
{
    /* Содержание */
    public $headerStep1;
    public $contentStep1;
    public $headerStep2;
    public $contentStep2;
    public $headerStep3;
    public $contentStep3;
    public $headerStep4;
    public $contentStep4;
    /* Стили (классы) */
    public $classLinkStep1;
    public $classContentStep1;
    public $classLinkStep2;
    public $classContentStep2;
    public $classLinkStep3;
    public $classContentStep3;
    public $classLinkStep4;
    public $classContentStep4;
    /* ссылки */
    public $urlStep1;
    public $urlStep2;
    public $urlStep3;
    public $urlStep4;

    public function init()
    {
        parent::init();
        $this->urlStep1 = Url::to(['/ad/default/index']);
        $this->registerClientScript();
    }

    public function run()
    {
        return $this->render(
            'steps',
            [
                'widget' => $this,
            ]);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        // Регистрация виджета
        StepsAsset::register($view);

        $js = <<< JS
            function  comeHere(id) {
                if($(id).attr('id') == "linkStep1" && $(id).attr('class') == '') {
                    $.pjax({url: "$this->urlStep1", container: '#w0'});
                }
            };
JS;
        $view->registerJs($js, View::POS_HEAD);

        $js = <<< JS
        $(document).ready(function () {
            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                var target = $(e.target);
                if (target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {
                //alert("click next-step");
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);
            });
            $(".prev-step").click(function (e) {
                //alert("click prev-step");
                var active = $('.wizard .nav-tabs li.active');
                prevTab(active);
            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
            //alert("go next-step");
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
            //alert("go prev-step");
        }

        function comeHere(id) {
            if($(id).attr('id') == "linkStep1" && $(id).attr('class') == '') {
                    $.pjax({url: "$this->urlStep1", container: '#w0'});
                }
        }
JS;
        $view->registerJs($js);
    }
}