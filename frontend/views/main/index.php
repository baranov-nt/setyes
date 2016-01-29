<?php
/* @var $this yii\web\View
 * @var $hello string */
use common\widgets\GoogleMapsMarkers\GoogleMaps;
//use common\widgets\CurrencyConverter\CurrencyConverter;
use yii\helpers\Url;
use yii\helpers\Html;

if (Yii::$app->user->can('Редактор')):
    Yii::$app->assetManager->forceCopy = true;
endif;
?>
<div class="container">
<?php
if(!Yii::$app->user->isGuest):
    echo '<br>'.Yii::$app->formatter->asDatetime(Yii::$app->user->identity['created_at']);
    echo '<br>'.Yii::$app->timezone->name;
    //Yii::$app->session->remove('timezone');
endif;
?>
</div>
<div class="container">
    <?php
    // вывод id страны
    //d(\Yii::$app->getRequest()->getCookies()->getValue('_countryId'));

    // конвертер валют
    /*$converter = new CurrencyConverter();
    $rate =  $converter->convert('EUR', 'MYR');
    d($rate);*/
    if(Yii::$app->user->can('Создатель')):
        echo Html::a(Yii::t('references', 'Real Estate'), Url::to(['/ad/real-estate/index']));
    endif;
    ?>

</div>
    <div class="container">
        <?php
        echo GoogleMaps::widget([
            'googleMapsUrlOptions' => [
                //'key' => Yii::$app->googleApi->geocode_api_key,
                'language' => Yii::$app->language,
                'version' => '3.1.18'
            ],
            'googleMapsOptions' => [
                'mapTypeId' => 'roadmap',
                //'tilt' => 45,
                'zoom' => 1
            ]
        ]);
        ?>
    </div>


