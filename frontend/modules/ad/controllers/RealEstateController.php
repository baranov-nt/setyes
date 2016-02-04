<?php

namespace frontend\modules\ad\controllers;

use Yii;
use common\models\AdRealEstate;
use common\models\AdRealEstateSearch;
use frontend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;

/**
 * RealEstateController implements the CRUD actions for AdRealEstate model.
 */
class RealEstateController extends BehaviorsController
{
    /**
     * Lists all AdRealEstate models.
     * @return mixed
     */
    /* @var $modelAdRealEstate \common\models\AdRealEstate */

    public function actionIndex()
    {
        $searchModel = new AdRealEstateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdRealEstate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelAdRealEstate' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdRealEstate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'modelAdRealEstate' => $model,
            ]);
        }
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Комнаты"
     */
    public function actionCreateRooms()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = AdRealEstate::findOne(Yii::$app->session->get('tempId'));
        if(!isset($modelAdRealEstate)):
            Yii::$app->session->remove('tempModel');
            Yii::$app->session->remove('tempId');
        endif;
        if (isset($modelAdRealEstate) && $modelAdRealEstate->load(Yii::$app->request->post())):
            /* @var $modelAdRealEstate \common\models\AdRealEstate */
            if($modelAdRealEstate->updateObject($modelAdRealEstate)):
                return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
            endif;
        endif;
        if(Yii::$app->session->get('tempModel') != 'AdRealEstate'):
            $modelAdRealEstate = new AdRealEstate();
            $modelAdRealEstate = $modelAdRealEstate->createObject();
        endif;
        
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* Установка сценария по умолчанию для комнат */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'rooms']);
        $modelAdRealEstate->property = 1;                                                               // свойство property (недвижемость) для комнат равно 1
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');     // Получаем город из куки

        // Ссылка Pjax для выпадающего списка выбора операции (свойство deal_type)
        $pjaxUrl = 'create-rooms';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                /** Если операция не соответствует сценарию, назначаем сценарий для комнат по умолчанию 'rooms' и очищаем ошибку
                 *  Используется когда отправляется уже с выбранным сценарием */
                $modelAdRealEstate->scenario = 'rooms';
                $modelAdRealEstate->clearErrors('deal_type');
            }

            /** Если в выпадающем списке выбрана операция 'selling room' (значение 8) и используется сценарий для комнат по умолчанию 'rooms'
             *  назначаем новый сценарий 'sellingRoom', где в модели $modelAdRealEstate
             *  $modelAdRealEstate->property = 1 (тип недвижемости - комнаты)
             *  $modelAdRealEstate->deal_type = 8 (тип операции)
             *  $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');
             * */
            if($modelAdRealEstate->deal_type == 8 && $modelAdRealEstate->scenario == 'rooms') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 1, $scenario = 'sellingRoom'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            /** Если была отправлена форма кнопкой submit
             *  $modelAdRealEstate->deal_type = 8 (тип операции)
             *  проверяем заполенные поля для сценария 'sellingRoom'
             * */
            if($modelAdRealEstate->deal_type == 8) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingRoom', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 9 && $modelAdRealEstate->scenario == 'rooms') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 1, $scenario = 'rentARoom'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 9) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentARoom', $modelAdRealEstate);
            }

            /* Если тип операции "куплю комнату" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 10 && $modelAdRealEstate->scenario == 'rooms') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 1, $scenario = 'buyRoom'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 10) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyRoom', $modelAdRealEstate);
            }

            /* Если тип операции "сниму комнату" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 11 && $modelAdRealEstate->scenario == 'rooms') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 1, $scenario = 'rentingARoom'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 11) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentingARoom', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация или запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }



    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Квартиры"
     */
    public function actionCreateApartrments()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'apartments']);
        $modelAdRealEstate->property = 2;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-apartrments';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'apartments';
            }
            $modelAdRealEstate->clearErrors('deal_type');

            if($modelAdRealEstate->deal_type == 12 && $modelAdRealEstate->scenario == 'apartments') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 2, $scenario = 'sellingApatrment'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 12) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingApatrment', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 13 && $modelAdRealEstate->scenario == 'apartments') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 2, $scenario = 'rentApatrment'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 13) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentApatrment', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 14 && $modelAdRealEstate->scenario == 'apartments') {
                 return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 2, $scenario = 'buyApatrment'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 14) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyApatrment', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 15 && $modelAdRealEstate->scenario == 'apartments') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 2, $scenario = 'rentingApatrment'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 15) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentingApatrment', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Дома, коттеджы"
     */
    public function actionCreateHousesCottages()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'houses']);
        $modelAdRealEstate->property = 3;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-houses-cottages';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'houses';
            }
            $modelAdRealEstate->clearErrors('deal_type');
            if($modelAdRealEstate->deal_type == 16 && $modelAdRealEstate->scenario == 'houses') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 3, $scenario = 'sellingHouse'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 16) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingHouse', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 17 && $modelAdRealEstate->scenario == 'houses') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 3, $scenario = 'rentHouse'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 17) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentHouse', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 18 && $modelAdRealEstate->scenario == 'houses') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 3, $scenario = 'buyHouse'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 18) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyHouse', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 19 && $modelAdRealEstate->scenario == 'houses') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 3, $scenario = 'rentingHouse'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 19) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentingHouse', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Земельные участки"
     */
    public function actionCreateLandPlot()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'land']);
        $modelAdRealEstate->property = 4;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-land-plot';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'land';
            }
            $modelAdRealEstate->clearErrors('deal_type');

            if($modelAdRealEstate->deal_type == 20 && $modelAdRealEstate->scenario == 'land') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 4, $scenario = 'sellingLand'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 20) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingLand', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 21 && $modelAdRealEstate->scenario == 'land') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 4, $scenario = 'buyLand'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 21) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyLand', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Гаражи, парковка"
     */
    public function actionCreateGaragesParking()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'garages']);
        $modelAdRealEstate->property = 5;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-garages-parking';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'garages';
            }
            $modelAdRealEstate->clearErrors('deal_type');
            if($modelAdRealEstate->deal_type == 22 && $modelAdRealEstate->scenario == 'garages') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 5, $scenario = 'sellingGarage'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 22) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingGarage', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 23 && $modelAdRealEstate->scenario == 'garages') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 5, $scenario = 'rentGarage'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 23) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentGarage', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 24 && $modelAdRealEstate->scenario == 'garages') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 5, $scenario = 'buyGarage'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 24) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyGarage', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 25 && $modelAdRealEstate->scenario == 'garages') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 5, $scenario = 'rentingGarage'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 25) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentingGarage', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Недвижимость за рубежом"
     */
    public function actionCreatePropertyAbroad()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'propertyAbroad']);
        $modelAdRealEstate->property = 6;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-property-abroad';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'propertyAbroad';
            }
            $modelAdRealEstate->clearErrors('deal_type');

            if($modelAdRealEstate->deal_type == 26 && $modelAdRealEstate->scenario == 'propertyAbroad') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 6, $scenario = 'sellingPropertyAbroad'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 26) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingPropertyAbroad', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 27 && $modelAdRealEstate->scenario == 'propertyAbroad') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 6, $scenario = 'buyPropertyAbroad'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 27) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyPropertyAbroad', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Коммерческая недвижимость"
     */
    public function actionCreateCommercialProperty()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'comercial']);
        $modelAdRealEstate->property = 7;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-commercial-property';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'comercial';
            }
            $modelAdRealEstate->clearErrors('deal_type');
            if($modelAdRealEstate->deal_type == 28 && $modelAdRealEstate->scenario == 'comercial') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 7, $scenario = 'sellingComercial'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 28) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'sellingComercial', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 29 && $modelAdRealEstate->scenario == 'comercial') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 7, $scenario = 'rentComercial'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 29) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentComercial', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 30 && $modelAdRealEstate->scenario == 'comercial') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 7, $scenario = 'buyComercial'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 30) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'buyComercial', $modelAdRealEstate);
            }

            if($modelAdRealEstate->deal_type == 31 && $modelAdRealEstate->scenario == 'comercial') {
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType = $modelAdRealEstate->deal_type, $property = 7, $scenario = 'rentingComercial'),
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 31) {
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = 'rentingComercial', $modelAdRealEstate);
            }

            if($modelAdRealEstate) {
                /* Если валидация и запись прошла */
                d([$modelAdRealEstate->scenario, 'OK']);
            }
            /* Если валидация и запись не прошла */
        }

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
            'pjaxUrl' => $pjaxUrl
        ]);
    }

    /**
     * Updates an existing AdRealEstate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'modelAdRealEstate' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdRealEstate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdRealEstate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdRealEstate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdRealEstate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
