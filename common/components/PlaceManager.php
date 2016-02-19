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
use yii\web\UnsupportedMediaTypeHttpException;

class PlaceManager extends Object
{
    public function init()
    {
        parent::init();
        if(\Yii::$app->session->get('browserError') == 1) {
            throw new UnsupportedMediaTypeHttpException(Yii::t('app', 'Your browser is too old! Open the app with something more modern -:) Thank you.'));
        }
    }
    /* Если находит главный город - записывает его в базу, если его там нет
       выставляет куки и передает id города из базы
       если не находит главный город чистит куки и передает false */
    public function setMainCity($place)
    {
        $object = Yii::$app->googleApi->getGeoCodeObject($place, null);
        /* Если вернулся объект города */
        if(isset($object)):
            $region = '';
            $country = '';
            foreach($object->address_components as $one):
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

    /* Находим город */
    public function findCity($city)
    {
        /* Находим город, заполненный в форме */
        $objectCity = Yii::$app->googleApi->getGeoCodeObject($city, null);
        if(isset($objectCity)):
            /* Если найден объект города, создаем пустые переменные для города */
            $region = '';
            $country = '';

            /* Формируем переменныe для города */
            foreach($objectCity->address_components as $one):
                if($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                    $region = $one->short_name;
                endif;
                if($one->types[0] == 'country'):
                    $country = $one->short_name;
                endif;
            endforeach;

            if($objectCity):
                /* Находим введенный город в базе по place_id */
                /* @var $modelPlaceCity \common\models\PlaceCity */
                $modelPlaceCity = PlaceCity::findOne(['place_id' => $objectCity->place_id]);

                if($modelPlaceCity):
                    return $modelPlaceCity;
                else:
                    // если город не найден, находим регион
                    $objectRegion = Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                    // ищем регион в базе
                    /* @var $modelPlaceRegion \common\models\PlaceRegion */
                    $modelPlaceRegion = PlaceRegion::findOne(['place_id' => $objectRegion->place_id]);

                    if($modelPlaceRegion):
                        // если регион найден
                        $modelPlaceCity = new PlaceCity();
                        // добавляем новый город к найденному региону, возвращаем объект города
                        return $modelPlaceCity->createCity($modelPlaceRegion, $objectCity->place_id);
                    else:
                        // если регион не найден, находим страну
                        $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $country]);
                        // если страна найдена
                        if($modelPlaceCountry):
                            $modelPlaceRegion = new PlaceRegion();
                            // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city
                            return $modelPlaceRegion->createRegionAndCity($modelPlaceCountry, $objectRegion->place_id, $objectCity->place_id);
                        endif;
                    endif;
                endif;
            endif;
        endif;

        return false;
    }

    /* Находим адрес */
    public function findAddress($city, $address)
    {
        /* Находим город, заполненный в форме */
        $objectInputCity = Yii::$app->googleApi->getGeoCodeObject($city, null);
        //d($objectInputCity);
        /* Находим адрес */
        $objectAddress = Yii::$app->googleApi->getGeoCodeObject($address, null);

        if (isset($objectAddress)):
            /* Если найден объект адреса, создаем пустые переменные для адреса */
            $street_number = '';    // номер дома
            $city = '';             // город
            $region = '';           // область, регион
            $country = '';          // cnhfyf

            /* Формируем переменныe для адреса */
            foreach ($objectAddress->address_components as $one):
                if ($one->types[0] == 'street_number'):
                    $street_number = $one->short_name;
                endif;
                if ($one->types[0] == 'locality'):
                    $city = $one->short_name;
                endif;
                if ($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                    $region = $one->short_name;
                endif;
                if ($one->types[0] == 'country'):
                    $country = $one->short_name;
                endif;
            endforeach;

            if ($street_number):
                /* Если есть номер дома */
                /* Находим введенный адрес в базе по place_id */
                $modelPlaceAddress = PlaceAddress::findOne(['place_id' => $objectAddress->place_id]);

                if ($modelPlaceAddress) {
                    /* @var $modelPlaceAddress \common\models\PlaceAddress */
                    /** Если найденный place_id уже есть в таблице адресов place_address
                     *  Возвращаем объект адреса */
                    return $modelPlaceAddress;
                } else {
                    // если адрес не найден, находим город
                    $objectCity = Yii::$app->googleApi->getGeoCodeObject($city.' '.$region.' '.$country, null);

                    /* Если введенный город не совпадает с городом найденым по адресу, возвращаем false */
                    if($objectInputCity->place_id != $objectCity->place_id) {
                        return false;
                    }

                    /* Находим введенный город в базе по place_id */
                    /* @var $modelPlaceCity \common\models\PlaceCity */
                    $modelPlaceCity = PlaceCity::findOne(['place_id' => $objectCity->place_id]);

                    if($modelPlaceCity) {
                        /* Если город в базе найден, записываем адрес этого города и возващаем объект адреса из таблицы place_address */
                        $modelPlaceAddress = new PlaceAddress();
                        return $modelPlaceAddress->createAddress($modelPlaceCity, $objectAddress->place_id);
                    } else {
                        /* Если город в базе не найден, ищем регион в Google Maps */
                        $objectRegion = Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                        /** @var $modelPlaceRegion \common\models\PlaceRegion
                         *  ищем регион в базе */
                        $modelPlaceRegion = PlaceRegion::findOne(['place_id' => $objectRegion->place_id]);

                        if($modelPlaceRegion):

                            // если регион найден
                            $modelPlaceCity = new PlaceCity();
                            // добавляем новый город к найденному региону и новый адрес к городу, возващаем объект адреса
                            return $modelPlaceCity->createCityAndAddress($modelPlaceRegion, $objectCity->place_id, $objectAddress->place_id);
                        else:
                            // если регион не найден, находим страну в БД
                            $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $country]);
                            // если страна найдена
                            if($modelPlaceCountry):

                                $modelPlaceRegion = new PlaceRegion();
                                // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city, возвращаем объект адреса
                                return $modelPlaceRegion->createRegionAndCityAndAddress($modelPlaceCountry, $objectRegion->place_id, $objectCity->place_id, $objectAddress->place_id);
                            endif;
                        endif;
                    }
                }
            endif;
        endif;

        return false;
    }

    /* Находим адрес */
    public function findStreet($city, $address)
    {
        /* Находим город, заполненный в форме */
        $objectInputCity = Yii::$app->googleApi->getGeoCodeObject($city, null);
        /* Находим адрес */
        $objectStreet = Yii::$app->googleApi->getGeoCodeObject($address, null);

        $route = '';
        /* Формируем переменныe для адреса */
        foreach ($objectStreet->address_components as $one):
            if ($one->types[0] == 'route'):
                $route = $one->short_name;
            endif;
        endforeach;

        $objectStreet = Yii::$app->googleApi->getGeoCodeObject($route.' '.$city, null);

        //d($objectStreet);

        if (isset($objectStreet)):
            /* Если найден объект адреса, создаем пустые переменные для адреса */
            $route = '';            // улица
            $city = '';             // город
            $region = '';           // область, регион
            $country = '';          // cnhfyf

            /* Формируем переменныe для адреса */
            foreach ($objectStreet->address_components as $one):
                if ($one->types[0] == 'route'):
                    $route = $one->short_name;
                endif;
                if ($one->types[0] == 'locality'):
                    $city = $one->short_name;
                endif;
                if ($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                    $region = $one->short_name;
                endif;
                if ($one->types[0] == 'country'):
                    $country = $one->short_name;
                endif;
            endforeach;

            if ($route):
                /* Если есть номер дома */
                /* Находим введенный адрес в базе по place_id */
                $modelPlaceAddress = PlaceAddress::findOne(['place_id' => $objectStreet->place_id]);

                if ($modelPlaceAddress) {
                    /* @var $modelPlaceAddress \common\models\PlaceAddress */
                    /** Если найденный place_id уже есть в таблице адресов place_address
                     *  Возвращаем объект адреса */
                    return $modelPlaceAddress;
                } else {
                    // если адрес не найден, находим город
                    $objectCity = Yii::$app->googleApi->getGeoCodeObject($city.' '.$region.' '.$country, null);

                    /* Если введенный город не совпадает с городом найденым по адресу, возвращаем false */
                    if($objectInputCity->place_id != $objectCity->place_id) {
                        return false;
                    }

                    /* Находим введенный город в базе по place_id */
                    /* @var $modelPlaceCity \common\models\PlaceCity */
                    $modelPlaceCity = PlaceCity::findOne(['place_id' => $objectCity->place_id]);

                    if($modelPlaceCity) {
                        /* Если город в базе найден, записываем адрес этого города и возващаем объект адреса из таблицы place_address */
                        $modelPlaceAddress = new PlaceAddress();
                        return $modelPlaceAddress->createAddress($modelPlaceCity, $objectStreet->place_id);
                    } else {
                        /* Если город в базе не найден, ищем регион в Google Maps */
                        $objectRegion = Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                        /** @var $modelPlaceRegion \common\models\PlaceRegion
                         *  ищем регион в базе */
                        $modelPlaceRegion = PlaceRegion::findOne(['place_id' => $objectRegion->place_id]);

                        if($modelPlaceRegion):

                            // если регион найден
                            $modelPlaceCity = new PlaceCity();
                            // добавляем новый город к найденному региону и новый адрес к городу, возващаем объект адреса
                            return $modelPlaceCity->createCityAndAddress($modelPlaceRegion, $objectCity->place_id, $objectStreet->place_id);
                        else:
                            // если регион не найден, находим страну в БД
                            $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $country]);
                            // если страна найдена
                            if($modelPlaceCountry):

                                $modelPlaceRegion = new PlaceRegion();
                                // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city, возвращаем объект адреса
                                return $modelPlaceRegion->createRegionAndCityAndAddress($modelPlaceCountry, $objectRegion->place_id, $objectCity->place_id, $objectStreet->place_id);
                            endif;
                        endif;
                    }
                }
            endif;
        endif;

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

    public function setAddress($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $objectPlace = Yii::$app->googleApi->getGeoCodeObject(null, null, $modelAdRealEstate->placeAddress->place_id);
        /* Формируем переменныe для адреса */
        $street_number = '';
        $route = '';
        $city = '';
        $region = '';
        $country = '';
        foreach ($objectPlace->address_components as $one):
            if ($one->types[0] == 'street_number'):
                $street_number = $one->short_name;
            endif;
            if ($one->types[0] == 'route'):
                $route = $one->short_name;
            endif;
            if ($one->types[0] == 'locality'):
                $city = $one->short_name;
            endif;
            if ($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                $region = $one->short_name;
            endif;
            if ($one->types[0] == 'country'):
                $country = $one->long_name;
            endif;

            $modelAdRealEstate->place_city = $city.', '.$region.', '.$country;
            $modelAdRealEstate->place_street = $route;
            $modelAdRealEstate->place_house = $street_number;
        endforeach;
        return $modelAdRealEstate;
    }

    public function getAddress($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $objectPlace = Yii::$app->googleApi->getGeoCodeObject(null, null, $modelAdRealEstate->placeAddress->place_id);
        /* Формируем переменныe для адреса */
        $address = '';
        $street_number = '';
        $route = '';
        $city = '';
        $region = '';
        $country = '';
        foreach ($objectPlace->address_components as $one):
            if ($one->types[0] == 'street_number'):
                $street_number = $one->short_name;
            endif;
            if ($one->types[0] == 'route'):
                $route = $one->short_name;
            endif;
            if ($one->types[0] == 'locality'):
                $city = $one->short_name;
            endif;
            if ($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                $region = $one->short_name;
            endif;
            if ($one->types[0] == 'country'):
                $country = $one->long_name;
            endif;

            $address = $city.', '.$region.', '.$country.', '.$route.', '.$street_number;
        endforeach;
        return $address;
    }

    public function setCity($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /** Если город объявления совпадает с текущим городом, устанавливаем значение главного города,
         *  иначе находим город */
        $mainCityPlaceId = Yii::$app->request->cookies->getValue('_cityPlaceId');
        $currentCityPlaceId = $modelAdRealEstate->adCategory->adMain->placeCity->place_id;
        if($mainCityPlaceId == $currentCityPlaceId) {
            $modelAdRealEstate->place_city = Yii::$app->request->cookies->getValue('_city');
        } else {
            $objectPlace = Yii::$app->googleApi->getGeoCodeObject(null, null, $currentCityPlaceId);
            $modelAdRealEstate->place_city = $objectPlace->formatted_address;
        }
        return $modelAdRealEstate;
    }

    public function getCity($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /** Если город объявления совпадает с текущим городом, устанавливаем значение главного города,
         *  иначе находим город */
        $mainCityPlaceId = Yii::$app->request->cookies->getValue('_cityPlaceId');
        $currentCityPlaceId = $modelAdRealEstate->adCategory->adMain->placeCity->place_id;
        if($mainCityPlaceId == $currentCityPlaceId) {
            $city = Yii::$app->request->cookies->getValue('_city');
        } else {
            $objectPlace = Yii::$app->googleApi->getGeoCodeObject(null, null, $currentCityPlaceId);
            $city = $objectPlace->formatted_address;
        }
        return $city;
    }

    public function testBrowser() {}
}