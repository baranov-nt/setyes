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
    public $titleMeta;
    public $siteNameMeta;
    public $descriptionMeta;
    public $imageMeta = 'logo.jpg';
    public $urlMeta = '';
    public $appFbIdMeta = '618854251589299';

    public function init()
    {
        parent::init();
        $this->titleMeta = Yii::$app->name;
        $this->siteNameMeta = Yii::$app->name;
        $this->descriptionMeta = Yii::t('app', 'Free classifieds from all over the world !!!');
    }

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
                        'actions' => ['reg', 'login', 'update-phone'],
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
                        'controllers' => ['main'],
                        'actions' => ['logout'],
                        'verbs' => ['POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['ad/default'],
                        'actions' => ['index'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['Администратор']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['ad/real-estate'],
                        'actions' => ['index', 'create', 'view', 'update', 'delete',
                            'create-rooms', 'create-apartrments', 'create-houses-cottages', 'create-land-plot', 'create-garages-parking', 'create-property-abroad', 'create-commercial-property',
                            'select-deal', 'complite', 'select-style', 'publish'],
                        'roles' => ['Администратор']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['ad/view'],
                        'actions' => ['all', 'one', 'add-to-favorites', 'delete-from-favorites', 'favorites', 'update', 'delete'],
                        'roles' => ['Администратор']
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