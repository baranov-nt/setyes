<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.12.2015
 * Time: 13:53
 */

namespace common\components;

use Yii;
use yii\web\UrlRule;

class CityUrlRule extends UrlRule {

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        //dd(Yii::$app->request->get());
        //$city = Yii::$app->session->get('citywww');

        //$city = Yii::$app->request->get('city');

        //dd($city);

        /*if($city):
            return $route.'?city='.$city;
            //Yii::$app->session->get('city_id');
        endif;*/

        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
        }
        return false;  // это правило не подходит
    }
}