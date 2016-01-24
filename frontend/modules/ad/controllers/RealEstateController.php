<?php

namespace frontend\modules\ad\controllers;

use Yii;
use common\models\AdRealEstate;
use common\models\AdRealEstateSearch;
use frontend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RealEstateController implements the CRUD actions for AdRealEstate model.
 */
class RealEstateController extends BehaviorsController
{
    /**
     * Lists all AdRealEstate models.
     * @return mixed
     */
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
            'model' => $this->findModel($id),
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
                'model' => $model,
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
        $modelAdRealEstate = new AdRealEstate(['scenario' => 'rooms']);
        $modelAdRealEstate->property = 1;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

        $pjaxUrl = 'create-rooms';

        if ($modelAdRealEstate->load(Yii::$app->request->post())) {
            d([$modelAdRealEstate->deal_type, $modelAdRealEstate->scenario]);
            if(!$modelAdRealEstate->validate(['deal_type'])) {
                $modelAdRealEstate->scenario = 'rooms';
            }
            $modelAdRealEstate->clearErrors('deal_type');
            /* Если тип операции "Продажа комнаты" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 8 && $modelAdRealEstate->scenario == 'rooms') {
                $modelAdRealEstate->validate();
                $modelAdRealEstate = new AdRealEstate(['scenario' => 'sellingRoom']);
                $modelAdRealEstate->property = 1;
                $modelAdRealEstate->deal_type = 8;
                $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

                return $this->render('create', [
                    'model' => $modelAdRealEstate,
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 8) {
                $modelAdRealEstate->scenario = 'sellingRoom';
                if($modelAdRealEstate->validate()) {
                    d($modelAdRealEstate);
                    dd('sellingRoom OK!!!');
                } else {
                    return $this->render('create', [
                        'model' => $modelAdRealEstate,
                        'pjaxUrl' => $pjaxUrl
                    ]);
                }
            }

            /* Если тип операции "сдам комнату" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 9 && $modelAdRealEstate->scenario == 'rooms') {
                $modelAdRealEstate->validate();
                $modelAdRealEstate = new AdRealEstate(['scenario' => 'rentARoom']);
                $modelAdRealEstate->property = 1;
                $modelAdRealEstate->deal_type = 9;
                $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

                return $this->render('create', [
                    'model' => $modelAdRealEstate,
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 9) {
                $modelAdRealEstate->scenario = 'rentARoom';
                if($modelAdRealEstate->validate()) {
                    d($modelAdRealEstate);
                    dd('rentARoom OK!!!');
                } else {
                    return $this->render('create', [
                        'model' => $modelAdRealEstate,
                        'pjaxUrl' => $pjaxUrl
                    ]);
                }
            }

            /* Если тип операции "куплю комнату" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 10 && $modelAdRealEstate->scenario == 'rooms') {
                $modelAdRealEstate->validate();
                $modelAdRealEstate = new AdRealEstate(['scenario' => 'buyRoom']);
                $modelAdRealEstate->property = 1;
                $modelAdRealEstate->deal_type = 10;
                $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

                return $this->render('create', [
                    'model' => $modelAdRealEstate,
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 10) {
                $modelAdRealEstate->scenario = 'buyRoom';
                if($modelAdRealEstate->validate()) {
                    d($modelAdRealEstate);
                    dd('buyRoom OK!!!');
                } else {
                    return $this->render('create', [
                        'model' => $modelAdRealEstate,
                        'pjaxUrl' => $pjaxUrl
                    ]);
                }
            }

            /* Если тип операции "сниму комнату" назначаем новый сценарий */
            if($modelAdRealEstate->deal_type == 11 && $modelAdRealEstate->scenario == 'rooms') {
                $modelAdRealEstate->validate();
                $modelAdRealEstate = new AdRealEstate(['scenario' => 'rentingARoom']);
                $modelAdRealEstate->property = 1;
                $modelAdRealEstate->deal_type = 11;
                $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');

                return $this->render('create', [
                    'model' => $modelAdRealEstate,
                    'pjaxUrl' => $pjaxUrl
                ]);
            }

            if($modelAdRealEstate->deal_type == 11) {
                $modelAdRealEstate->scenario = 'rentingARoom';
                if($modelAdRealEstate->validate()) {
                    d($modelAdRealEstate);
                    dd('rentingARoom OK!!!');
                } else {
                    return $this->render('create', [
                        'model' => $modelAdRealEstate,
                        'pjaxUrl' => $pjaxUrl
                    ]);
                }
            }

            return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
        } else {
            return $this->render('create', [
                'model' => $modelAdRealEstate,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'apartments']);
        $model->property = 2;
        $pjaxUrl = 'create-apartrments';

        if ($model->load(Yii::$app->request->post())) {
            dd($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'housesCottages']);
        $model->property = 3;
        $pjaxUrl = 'create-houses-cottages';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'landPlot']);
        $model->property = 4;
        $pjaxUrl = 'create-land-plot';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'garagesParking']);
        $model->property = 5;
        $pjaxUrl = 'create-garages-parking';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'propertyAbroad']);
        $model->property = 6;
        $pjaxUrl = 'create-property-abroad';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
        }
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
        $model = new AdRealEstate(['scenario' => 'commercialProperty']);
        $model->property = 7;
        $pjaxUrl = 'create-commercial-property';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'pjaxUrl' => $pjaxUrl
            ]);
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
