<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 13.12.2015
 * Time: 23:01
 */

namespace common\widgets\GooglePlacesAutoComplete;

use yii\widgets\InputWidget;
use yii\helpers\Html;
class GooglePlacesAutoComplete extends InputWidget {
    const API_URL = '//maps.googleapis.com/maps/api/js?';
    public $libraries = 'places';
    public $sensor = false;

    public $language = 'en-US';
    public $autocompleteOptions = [];

    // Renders the widget.

    public function run(){
        $this->registerClientScript();

        $this->value = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        if ($this->hasModel()) {
            $this->options['class'] = 'form-control';
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $this->options['class'] = 'form-control';
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    //  Registers the needed JavaScript.

    public function registerClientScript(){
        $elementId = $this->options['id'];
        $scriptOptions = json_encode($this->autocompleteOptions);
        $view = $this->getView();
        $view->registerJsFile(self::API_URL . http_build_query([
                'libraries' => $this->libraries,
                'sensor' => $this->sensor ? 'true' : 'false',
                'language' => $this->language
            ]));
        $view->registerJs(<<<JS
(function(){
    var input = document.getElementById('{$elementId}');
    var options = {$scriptOptions};
    new google.maps.places.Autocomplete(input, options);
})();
JS
            , \yii\web\View::POS_READY);
    }
}

/*use yii\widgets\InputWidget;
use yii\helpers\Html;

class GooglePlacesAutoComplete extends InputWidget {

    const API_URL = '//maps.googleapis.com/maps/api/js?';

    public $libraries = 'places';

    public $language = 'en';

    public $autocompleteOptions = [
        'types' =>  [
            '(cities)'
        ],
        'componentRestrictions' => [
            //'country' => 'ru', 'fr'
        ]
    ];


    public function run(){
        $this->registerClientScript();

        $this->value = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        if ($this->hasModel()) {
            $this->options['class'] = 'form-control';
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $this->options['class'] = 'form-control';
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }


    public function registerClientScript(){
        $elementId = $this->options['id'];
        $scriptOptions = json_encode($this->autocompleteOptions);
        $view = $this->getView();
        $view->registerJsFile(self::API_URL . http_build_query([
                'libraries' => $this->libraries,
                'language' => \Yii::$app->language,
            ]));

        $view->registerJs(<<<JS
        (function(){
            var input = $('#{$elementId}');
            input.click(function() {
                input.val("");
            });
        })();
JS
            , \yii\web\View::POS_READY);

        $view->registerJs(<<<JS
            (function(){
                var input = document.getElementById('{$elementId}');
                var options = {$scriptOptions};
                var autocomplete = new google.maps.places.Autocomplete(input, options);
            })();
JS
            , \yii\web\View::POS_READY);
    }
}*/
