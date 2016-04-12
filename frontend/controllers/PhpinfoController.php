<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.04.2016
 * Time: 9:23
 */

namespace frontend\controllers;

use yii\web\Controller;

class PhpinfoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}