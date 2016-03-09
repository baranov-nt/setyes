<?php

namespace frontend\modules\ad\controllers;

use Yii;
use common\models\AdTransport;
use common\models\AdTransportSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\controllers\BehaviorsController;

/**
 * TransportController implements the CRUD actions for AdTransport model.
 */
class TransportController extends BehaviorsController
{
    /**
     * Lists all AdTransport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdTransportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdTransport model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdTransport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $modelAdTransport \common\models\AdTransport */
        $modelAdTransport = new AdTransport(['scenario' => 'default']);

        if ($modelAdTransport->load(Yii::$app->request->post())) {
            $modelAdTransport = $modelAdTransport->checkForm($scenario = $modelAdTransport->model_scenario, $modelAdTransport);
            if($modelAdTransport->errors) {
                if(isset($modelAdTransport->errors['model_is']) && $modelAdTransport->errors['model_is']) {
                    Yii::$app->session->setFlash('info', Yii::t('app', 'You already have such an ad.'));
                    return $this->redirect(['/ad/view/complite', 'id' => $modelAdTransport->adCategory->adMain->id]);
                }
                return $this->render('create', [
                    'modelAdTransport' => $modelAdTransport,
                ]);
            } else {
                //dd('OK!!!');
                return $this->redirect(['view', 'id' => $modelAdTransport->id]);
            }
        }

        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport,
        ]);
    }

    /**
     * Creates a new AdTransport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePassengerCar()
    {
        $modelAdTransport = new AdTransport(['scenario' => 'passengerCar']);
        $modelAdTransport->transport = 1;                                                               // свойство property (недвижемость) для комнат равно 1
        $modelAdTransport->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');     // Получаем город из куки

        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport,
        ]);
    }

    /**
     * Updates an existing AdTransport model.
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
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new AdTransport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * Действия для выбора сцегария в зависимости от пункта deal_type
     */
    public function actionSelectDeal()
    {
        /* @var $modelAdTransport \common\models\AdTransport */
        /* Установка сценария по умолчанию для комнат */
        $modelAdTransport = new AdTransport();

        if ($modelAdTransport->load(Yii::$app->request->post())) {
            /** Операции для легковых автомобилей */
            if($modelAdTransport->deal_type == 16)
                $this->setScenario($modelAdTransport->deal_type, $transport = 1, $scenario = 'sellPassengerCar');
            if($modelAdTransport->deal_type == 17)
                $this->setScenario($modelAdTransport->deal_type, $transport = 1, $scenario = 'buyPassengerCar');
            if($modelAdTransport->deal_type == 18)
                $this->setScenario($modelAdTransport->deal_type, $transport = 1, $scenario = 'rentPassengerCar');
        }

        /* @var $modelAdTransport \common\models\AdTransport */
        //$modelAdTransport = new AdTransport(['scenario' => 'default']);

        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport,
        ]);
    }

    /**
     * Устанавливает в форме сценарий, согласно deal_type
     */
    protected function setScenario($dealType, $transport, $scenario)
    {
        $modelAdTransport = new AdTransport();
        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport->addNewScenario($dealType, $transport, $scenario),
        ]);
    }

    /**
     * Deletes an existing AdTransport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSelectMark()
    {
        /* @var $modelAdTransport \common\models\AdTransport */
        /* Установка сценария по умолчанию для комнат */
        $modelAdTransport = new AdTransport();

        $modelAdTransport->load(Yii::$app->request->post());
        $modelAdTransport->setScenario($modelAdTransport->model_scenario);

        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport,
        ]);
    }

    public function actionSelectModel()
    {
        /* @var $modelAdTransport \common\models\AdTransport */
        /* Установка сценария по умолчанию для комнат */
        $modelAdTransport = new AdTransport();

        $modelAdTransport->load(Yii::$app->request->post());
        $modelAdTransport->setScenario($modelAdTransport->model_scenario);

        return $this->render('create', [
            'modelAdTransport' => $modelAdTransport,
        ]);
    }

    /**
     * Finds the AdTransport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdTransport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdTransport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
