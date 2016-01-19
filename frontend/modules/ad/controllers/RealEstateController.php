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
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

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
        $model = new AdRealEstate(['scenario' => 'rooms']);
        $model->property = 1;

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
     * Действия для создания объявлений раздела "Квартиры"
     */
    public function actionCreateApartrments()
    {
        $model = new AdRealEstate(['scenario' => 'apartments']);
        $model->property = 2;

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
     * Действия для создания объявлений раздела "Дома, коттеджы"
     */
    public function actionCreateHousesCottages()
    {
        $model = new AdRealEstate(['scenario' => 'housesCottages']);
        $model->property = 3;

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
     * Действия для создания объявлений раздела "Земельные участки"
     */
    public function actionCreateLandPlot()
    {
        $model = new AdRealEstate(['scenario' => 'landPlot']);
        $model->property = 4;

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
     * Действия для создания объявлений раздела "Гаражи, парковка"
     */
    public function actionCreateGaragesParking()
    {
        $model = new AdRealEstate(['scenario' => 'garagesParking']);
        $model->property = 5;

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
     * Действия для создания объявлений раздела "Недвижимость за рубежом"
     */
    public function actionCreatePropertyAbroad()
    {
        $model = new AdRealEstate(['scenario' => 'propertyAbroad']);
        $model->property = 6;

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
     * Действия для создания объявлений раздела "Коммерческая недвижимость"
     */
    public function actionCreateCommercialProperty()
    {
        $model = new AdRealEstate(['scenario' => 'commercialProperty']);
        $model->property = 7;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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