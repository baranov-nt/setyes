<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.01.2016
 * Time: 9:56
 */

namespace common\components;

use Yii;
use yii\base\Object;
use yii\web\Cookie;
use common\models\PlaceAddress;
use common\models\PlaceCity;
use common\models\PlaceRegion;
use common\models\PlaceCountry;

class PlaceManager extends Object
{
    /* Если находит главный город - записывает его в базу, если его там нет
       выставляет куки и передает id города из базы
       если не находит главный город чистит куки и передает false */
    public function setMainCity($place)
    {
        $object = Yii::$app->googleApi->getGeoCodeObject($place, null);
        /* Если вернулся объект города */
        if(isset($object)):
            $city = '';
            $region = '';
            $country = '';
            foreach($object->address_components as $one):
                if($one->types[0] == 'locality'):
                    $city = $one->short_name;
                endif;
                if($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                    $region = $one->short_name;
                endif;
                if($one->types[0] == 'country'):
                    $country = $one->short_name;
                endif;
            endforeach;

            /*$object = \Yii::$app->googleApi->getGeoCodeObject("проспект Строителей, Нижний Тагил, Свердловская область, Россия 5", null);
            dd($object);*/
            $formattedAddress = $object->formatted_address;            // форматированный адрес (строка)
            $cityPlaceId = $object->place_id;                               // идентификатор города

            /* Находим введенный город в базе по place_id */
            /* @var $modelPlaceCity \common\models\PlaceCity */
            $modelPlaceCity = PlaceCity::findOne(['place_id' => $cityPlaceId]);

            if($modelPlaceCity):
                // если город найден выставляем куки и переходим на главную страницу с get переменной city
                $this->setCookie($formattedAddress, $modelPlaceCity);
                Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                return $modelPlaceCity->id;
            else:
                // если город не найден, находим регион
                $objectRegion = Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                $regionPlaceId = $objectRegion->place_id;
                // ищем регион в базе
                /* @var $modelPlaceRegion \common\models\PlaceRegion */
                $modelPlaceRegion = PlaceRegion::findOne(['place_id' => $regionPlaceId]);

                if($modelPlaceRegion):
                    // если регион найден
                    $modelPlaceCity = new PlaceCity();
                    // добавляем новый город к найденному региону, пишем куки и переходим на главную страницу с get переменной city
                    $modelPlaceCity = $modelPlaceCity->createCity($modelPlaceRegion, $cityPlaceId);
                    $this->setCookie($formattedAddress, $modelPlaceCity);
                    Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                    return $modelPlaceCity->id;
                else:
                    // если регион не найден, находим страну
                    foreach($object->address_components as $one):
                        if($one->types[0] == 'country'):
                            $country = $one->short_name;
                        endif;
                    endforeach;
                    $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $country]);
                    // если страна найдена
                    if($modelPlaceCountry):
                        $modelPlaceRegion = new PlaceRegion();
                        // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city
                        $modelPlaceCity = $modelPlaceRegion->createRegionAndCity($modelPlaceCountry, $regionPlaceId, $cityPlaceId);
                        $this->setCookie($formattedAddress, $modelPlaceCity);
                        Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                        return $modelPlaceCity->id;
                    endif;
                endif;
            endif;
        endif;

        $this->clearCookie();

        return false;
    }

    private function setCookie($formattedAddress, $modelPlaceCity)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => '_city',
            'value' => $formattedAddress,
            'expire' => time() + 86400 * 365,
        ]));

        /* Страна в iso2 (например RU) */
        $cookies->add(new Cookie([
            'name' => '_cityId',
            'value' => $modelPlaceCity->id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id города */
        $cookies->add(new Cookie([
            'name' => '_cityPlaceId',
            'value' => $modelPlaceCity->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id региона */
        $cookies->add(new Cookie([
            'name' => '_regionId',
            'value' => $modelPlaceCity->region->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* Страна в iso2 (например RU) */
        $cookies->add(new Cookie([
            'name' => '_countryId',
            'value' => $modelPlaceCity->region->country->id,
            'expire' => time() + 86400 * 365,
        ]));
    }

    private function clearCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('_city');
        $cookies->remove('_cityId');
        $cookies->remove('_cityPlaceId');
        $cookies->remove('_regionId');
        $cookies->remove('_countryId');
    }
}