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

    public $connectionID = 'db';

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        /* Формируем url если есть сессия  */
        $citySession = Yii::$app->session->get('_cityId');
        if($citySession):
            return $citySession.'/'.$route;
        endif;

        /* Формируем url если есть куки  */
        $cityCookie = \Yii::$app->getRequest()->getCookies()->getValue('_cityId');
        if($cityCookie):
            return $cityCookie.'/'.$route;
        endif;

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