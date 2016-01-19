<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 30.06.2015
 * Time: 5:48
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BehaviorsController extends Controller {

    // Параметры для метатегов
    public $titleMeta = 'Бояр';
    public $siteNameMeta = 'Бояр';
    public $descriptionMeta = 'Заказ продуктов питания.';
    public $imageMeta = 'logo.jpg';
    public $urlMeta = '';
    public $appFbIdMeta = '618854251589299';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                /*'denyCallback' => function ($rule, $action) {
                    throw new \Exception('Нет доступа.');
                },*/
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['reg', 'login'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main', 'images'],
                        'actions' => ['profile', 'image-autoload', 'delete-avatar', 'login', 'user', 'logout'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['ad/default'],
                        'actions' => ['index'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['logout'],
                        'verbs' => ['POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['ad/real-estate'],
                        'actions' => ['index', 'create', 'view', 'update', 'delete',
                            'create-rooms', 'create-apartrments'],
                        'roles' => ['Создатель']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main', 'test'],
                        'actions' => ['index', 'search', 'send-email', 'reset-password', 'finish-reg', 'login', 'error', 'activate-account', 'view-profile', 'timezone', 'select-city']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['widget-test'],
                        'actions' => ['index'],
                        /*'ips' => ['127.1.*'],
                        'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '30-06';
                        }*/
                    ],
                ]
            ],
        ];
    }
}