<?php

namespace frontend\modules\ad\controllers;

use common\models\AdMain;
use Yii;
use common\models\AdRealEstate;
use common\models\AdRealEstateSearch;
use frontend\controllers\BehaviorsController;
use yii\web\MethodNotAllowedHttpException;
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
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = $this->findModel($id);

        if (Yii::$app->user->can('Автор', ['model' => $modelAdRealEstate->adCategory->adMain])) {

        if($modelAdRealEstate->placeAddress) {
            /* Устанавливаем поля в модели в соответствии с адресом */
            $modelAdRealEstate = Yii::$app->placeManager->setAddress($modelAdRealEstate);
        } else {
            /* Устанавливаем поля в модели в соответствии с городом */
            $modelAdRealEstate = Yii::$app->placeManager->setCity($modelAdRealEstate);
        }

        return $this->render('view', [
            'modelAdRealEstate' => $modelAdRealEstate
        ]);

        } else {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        }
    }

    /**
     * Updates an existing AdRealEstate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = $this->findModel($id);

        if (Yii::$app->user->can('Автор', ['model' => $modelAdRealEstate->adCategory->adMain])) {

        $modelAdRealEstate->setScenario($modelAdRealEstate->model_scenario);

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = $modelAdRealEstate->model_scenario, $modelAdRealEstate);
            if($modelAdRealEstate->errors) {
                if(isset($modelAdRealEstate->errors['model_is']) && $modelAdRealEstate->errors['model_is']) {
                    return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
                }
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate,
                ]);
            } else {
                //dd('OK!!!');
                return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
            }
        }

        if($modelAdRealEstate->placeAddress) {
            /* Устанавливаем поля в модели в соответствии с адресом */
            $modelAdRealEstate = Yii::$app->placeManager->setAddress($modelAdRealEstate);
        } else {
            /* Устанавливаем поля в модели в соответствии с городом */
            $modelAdRealEstate = Yii::$app->placeManager->setCity($modelAdRealEstate);
        }

        return $this->render('update', [
                'modelAdRealEstate' => $modelAdRealEstate,
            ]);

        } else {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        }
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'default']);

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = $modelAdRealEstate->model_scenario, $modelAdRealEstate);
            if($modelAdRealEstate->errors) {
                if(isset($modelAdRealEstate->errors['model_is']) && $modelAdRealEstate->errors['model_is']) {
                    Yii::$app->session->setFlash('info', Yii::t('app', 'You already have such an ad.'));
                    return $this->redirect(['/ad/view/complite', 'id' => $modelAdRealEstate->adCategory->adMain->id]);
                }
                return $this->render('create', [
                    'modelAdRealEstate' => $modelAdRealEstate,
                ]);
            } else {
                //dd('OK!!!');
                return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
            }
        }

        return $this->render('create', [
                'modelAdRealEstate' => $modelAdRealEstate,
            ]);
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'rooms']);
        $modelAdRealEstate->property = 1;                                                               // свойство property (недвижемость) для комнат равно 1
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');     // Получаем город из куки

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'apartments']);
        $modelAdRealEstate->property = 2;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'houses']);
        $modelAdRealEstate->property = 3;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'land']);
        $modelAdRealEstate->property = 4;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'garages']);
        $modelAdRealEstate->property = 5;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Недвижимость за рубежом"
     */

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для создания объявлений раздела "Коммерческая недвижимость"
     */
    public function actionCreateCommercialProperty()
    {
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'comercial']);
        $modelAdRealEstate->property = 6;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
        ]);
    }

    /**
     * Creates a new AdRealEstate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для выбора сцегария в зависимости от пункта deal_type
     */
    public function actionSelectDeal()
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* Установка сценария по умолчанию для комнат */
        $modelAdRealEstate = new AdRealEstate();

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            /**
             *
             * Операции для комнат */
            if($modelAdRealEstate->deal_type == 8)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 1, $scenario = 'sellingRoom');
            if($modelAdRealEstate->deal_type == 9)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 1, $scenario = 'rentARoom');
            if($modelAdRealEstate->deal_type == 10)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 1, $scenario = 'buyRoom');
            if($modelAdRealEstate->deal_type == 11)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 1, $scenario = 'rentingARoom');
            /* Операции для квартир */
            if($modelAdRealEstate->deal_type == 12)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 2, $scenario = 'sellingApatrment');
            if($modelAdRealEstate->deal_type == 13)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 2, $scenario = 'rentApatrment');
            if($modelAdRealEstate->deal_type == 14)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 2, $scenario = 'buyApatrment');
            if($modelAdRealEstate->deal_type == 15)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 2, $scenario = 'rentingApatrment');
            /* Операции с домами */
            if($modelAdRealEstate->deal_type == 16)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 3, $scenario = 'sellingHouse');
            if($modelAdRealEstate->deal_type == 17)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 3, $scenario = 'rentHouse');
            if($modelAdRealEstate->deal_type == 18)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 3, $scenario = 'buyHouse');
            if($modelAdRealEstate->deal_type == 19)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 3, $scenario = 'rentingHouse');
            /* Операции с землей */
            if($modelAdRealEstate->deal_type == 20)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 4, $scenario = 'sellingLand');
            if($modelAdRealEstate->deal_type == 21)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 4, $scenario = 'buyLand');
            /* Операции с гаражами */
            if($modelAdRealEstate->deal_type == 22)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 5, $scenario = 'sellingGarage');
            if($modelAdRealEstate->deal_type == 23)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 5, $scenario = 'rentGarage');
            if($modelAdRealEstate->deal_type == 24)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 5, $scenario = 'buyGarage');
            if($modelAdRealEstate->deal_type == 25)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 5, $scenario = 'rentingGarage');
            /* Операции с коммерческой недвижимостью */
            if($modelAdRealEstate->deal_type == 28)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 6, $scenario = 'sellingComercial');
            if($modelAdRealEstate->deal_type == 29)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 6, $scenario = 'rentComercial');
            if($modelAdRealEstate->deal_type == 30)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 6, $scenario = 'buyComercial');
            if($modelAdRealEstate->deal_type == 31)
                $this->setScenario($modelAdRealEstate->deal_type, $property = 6, $scenario = 'rentingComercial');
        }

        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'default']);

        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate,
        ]);
    }

    /**
     * Устанавливает в форме сценарий, согласно deal_type
     */
    protected function setScenario($dealType, $property, $scenario)
    {
        $modelAdRealEstate = new AdRealEstate();
        //dd($modelAdRealEstate->addNewScenario($dealType, $property, $scenario));
        return $this->render('create', [
            'modelAdRealEstate' => $modelAdRealEstate->addNewScenario($dealType, $property, $scenario),
        ]);
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
        if (($modelAdRealEstate = AdRealEstate::findOne($id)) !== null) {
            return $modelAdRealEstate;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return $this->redirect(['/ad/default/index']);
        }
    }

    /**
     * Finds the AdRealEstate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdRealEstate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAdMain($id)
    {
        if (($modelAdMain = AdMain::findOne($id)) !== null) {
            return $modelAdMain;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return $this->redirect(['/ad/default/index']);
        }
    }
}
