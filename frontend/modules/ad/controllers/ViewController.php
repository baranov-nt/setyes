<?php

namespace frontend\modules\ad\controllers;

use Yii;
use common\models\AdMain;
use common\models\AdMainSearch;
use yii\web\NotFoundHttpException;
use frontend\controllers\BehaviorsController;
use common\models\AdFavorite;

/**
 * ViewController implements the CRUD actions for AdMain model.
 */
class ViewController extends BehaviorsController
{
    /**
     * Lists all AdMain models.
     * @return mixed
     */
    public function actionAll()
    {
        $searchModel = new AdMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdMain model.
     * @param integer $id
     * @return mixed
     */
    public function actionOne($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionFavorites()
    {
        $searchModel = new AdMainSearch();

        $dataProvider = $searchModel->searchFavorites(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AdMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMy()
    {
        $searchModel = new AdMainSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AdMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionOpenInModal()
    {
        //dd(Yii::$app->request->post());
        $id = Yii::$app->request->post('id');
        $modalWindow = true;

        return $this->render('_modal-window', [
            'id' => $id,
            'modalWindow' => $modalWindow,
        ]);
    }

    /**
     * Creates a new AdMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdMain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        /* Если категория равна 1, делаем перенаправление на Недвижимость */
        if($model->adCategory->category == 1)
            return $this->redirect(['/ad/real-estate/update', 'id' => $model->adCategory->ad->id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdMain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed _icon-favorite
     */
    public function actionDelete()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $model->adCategory->ad->temp = 1;
        $model->adCategory->ad->save();

        return $this->renderAjax('@common/widgets/AdWidget/views/_delete_block');
    }

    public function actionAddToFavorites () {
        $id = Yii::$app->request->post('id');
        $modelAdFavorite = new AdFavorite();
        $modelAdFavorite->addToFavorite($id);

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-favorite',
            [
                'id' => $id,
                'icon' => Yii::$app->request->post('icon'),
                'ok' => 1
            ]);
    }

    public function actionDeleteFromFavorites () {
        $id = Yii::$app->request->post('id');
        $modelAdFavorite = new AdFavorite();
        $modelAdFavorite->deleteFromFavorite($id);

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-favorite-empty',
            [
                'id' => Yii::$app->request->post('id'),
                'icon' => Yii::$app->request->post('icon'),
                'ok' => 1
            ]);
    }

    /**
     * Finds the AdMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
