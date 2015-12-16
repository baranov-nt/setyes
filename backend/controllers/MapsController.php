<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.12.2015
 * Time: 14:07
 */
namespace backend\controllers;

use Yii;

class MapsController extends BehaviorsController
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [

            ]);
    }

    public function actionSelectCity()
    {
        $place = Yii::$app->request->post('place');
        $object = \Yii::$app->googleApi->getGeoCodeObject($place, null);

        if(isset($object)):
            $city = '';
            foreach($object->address_components as $one):
                if($one->types[0] == 'locality'):
                    $city .= $one->short_name.' ';
                endif;
                /*if($one->types[0] == 'administrative_area_level_2'):
                    $city .= $one->short_name.' ';
                endif;*/
                if($one->types[0] == 'administrative_area_level_1'):
                    $city .= $one->short_name.' ';
                endif;
                if($one->types[0] == 'country'):
                    $city .= $one->short_name.' ';
                endif;
            endforeach;
            $object = \Yii::$app->googleApi->getGeoCodeObject($city, null);
            $formattedAddress = $object->formatted_address;
            $idPlace = $object->place_id;

            if($formattedAddress != null && $idPlace != null):
                $cookies = Yii::$app->response->cookies;

                $cookies->add(new \yii\web\Cookie([
                    'name' => '_city',
                    'value' => $formattedAddress,
                    'expire' => time() + 86400 * 365,
                ]));

                $cookies->add(new \yii\web\Cookie([
                    'name' => '_placeId',
                    'value' => $idPlace,
                    'expire' => time() + 86400 * 365,
                ]));
            else:
                $cookies = Yii::$app->response->cookies;
                $cookies->remove('_city');
                $cookies->remove('_placeId');
            endif;
        else:
            $cookies = Yii::$app->response->cookies;
            $cookies->remove('_city');
            $cookies->remove('_placeId');
        endif;

        return $this->goBack();
    }
}