<?php

namespace frontend\modules\ad\controllers;

use common\models\AdComplains;
use common\models\PlaceCity;
use Yii;
use common\models\AdMain;
use common\models\AdMainSearch;
use yii\web\MethodNotAllowedHttpException;
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
        $city = Yii::$app->request->cookies->get('_cityId');
        if(isset($city))
            $searchModel->place_city_id = $city->value;
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
    public function actionShowInRegion()
    {
        $searchModel = new AdMainSearch();
        $city = Yii::$app->request->cookies->get('_cityId');
        if(isset($city)) {
            /* @var $modelPlaceCity \common\models\PlaceCity */
            $modelPlaceCity = PlaceCity::findOne($city);
            if(isset($modelPlaceCity))
                $searchModel->region_id = $modelPlaceCity->region->id;
        }

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
        $modelAdMain = $this->findModel($id);

        $items = $modelAdMain->getLargeImagesList($modelAdMain->getImagesOfObjects());

        return $this->render('view',
            [
                'modalWindow' => false,
                'user' => Yii::$app->user->identity,
                'template' => false,
                'id' => $id,
                'author' => Yii::$app->user->can('Автор', ['model' => $modelAdMain]),
                'main_container_class' =>$modelAdMain->adStyle->main_container_class,
                'favorite' => $modelAdMain->getFavorite($modelAdMain->id),
                'favorite_icon' => $modelAdMain->adStyle->favorite_icon,
                'header' => $modelAdMain->getHeader(),
                'address' => $modelAdMain->getAddress(),
                'address_map' => $modelAdMain->getAddressMap(),
                'phone_temp_ad' => $modelAdMain->phone_temp_ad,
                'items' => $items,
                'content' => $modelAdMain->getContentList(),
                'quick_view_class' => $modelAdMain->adStyle->quick_view_class,
                'background_color' => $modelAdMain->adStyle->background_color,
                'text_color' => $modelAdMain->adStyle->text_color
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
        $id = Yii::$app->request->post('id');

        $modelAdMain = $this->findModel($id);

        $items = $modelAdMain->getLargeImagesList($modelAdMain->getImagesOfObjects());

        $modalWindow = true;

        return $this->render('_modal-window',
            [
                'modalWindow' => $modalWindow,
                'user' => Yii::$app->user->identity,
                'template' => false,
                'id' => $id,
                'author' => Yii::$app->user->can('Автор', ['model' => $modelAdMain]),
                'main_container_class' =>$modelAdMain->adStyle->main_container_class,
                'favorite' => $modelAdMain->getFavorite($modelAdMain->id),
                'favorite_icon' => $modelAdMain->adStyle->favorite_icon,
                'header' => $modelAdMain->getHeader(),
                'address' => $modelAdMain->getAddress(),
                'address_map' => $modelAdMain->getAddressMap(),
                'phone_temp_ad' => $modelAdMain->phone_temp_ad,
                'items' => $items,
                'content' => $modelAdMain->getContentList(),
                'quick_view_class' => $modelAdMain->adStyle->quick_view_class,
                'background_color' => $modelAdMain->adStyle->background_color,
                'text_color' => $modelAdMain->adStyle->text_color
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
        $modelAdMain = $this->findModel(Yii::$app->request->post('id'));

        if (Yii::$app->user->can('Автор', ['model' => $modelAdMain])) {
            if($modelAdMain->adCategory->category == '1') {
                $modelAdMain->adCategory->ad->temp = 1;
                $modelAdMain->adCategory->ad->save();
            }
            Yii::$app->session->setFlash('notice', Yii::t('app', 'Message successfully deleted.'));
            return $this->renderAjax('@common/widgets/AdWidget/views/_delete_block');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddToFavorites () {
        $id = Yii::$app->request->post('id');
        $modelAdFavorite = new AdFavorite();
        $modelAdFavorite->addToFavorite($id);

        Yii::$app->session->setFlash('success', Yii::t('app', 'Ad added to favorites.'));

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-favorite',
            [
                'id' => $id,
                'icon' => Yii::$app->request->post('icon'),
            ]);
    }

    public function actionDeleteFromFavorites () {
        $id = Yii::$app->request->post('id');
        $modelAdFavorite = new AdFavorite();
        $modelAdFavorite->deleteFromFavorite($id);

        Yii::$app->session->setFlash('info', Yii::t('app', 'This ad is removed from your favorites.'));

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-favorite-empty',
            [
                'id' => Yii::$app->request->post('id'),
                'icon' => Yii::$app->request->post('icon'),
            ]);
    }

    public function actionComplite($id)
    {
        /* @var $modelAdMain \common\models\AdMain */
        $modelAdMain = $this->findModel($id);

        //dd($modelAdMain);

        if (Yii::$app->user->can('Автор', ['model' => $modelAdMain])) {

            /*if ($modelAdRealEstate->placeAddress) {
                // Устанавливаем поля в модели в соответствии с адресом
                $modelAdRealEstate = Yii::$app->placeManager->setAddress($modelAdRealEstate);
            } else {
                // Устанавливаем поля в модели в соответствии с городом
                $modelAdRealEstate = Yii::$app->placeManager->setCity($modelAdRealEstate);
            }

            if ($modelAdRealEstate->load(Yii::$app->request->post())) {

                $modelAdRealEstate->compliteAd($modelAdRealEstate);
                $modelAdRealEstate = $modelAdRealEstate->checkForm($scenario = $modelAdRealEstate->model_scenario, $modelAdRealEstate);
                if ($modelAdRealEstate->errors) {
                    return $this->render('create', [
                        'modelAdRealEstate' => $modelAdRealEstate,
                    ]);
                } else {
                    //dd('OK!!!');
                    return $this->redirect(['view', 'id' => $modelAdRealEstate->id]);
                }
            }*/

            return $this->render('complite', [
                'modelAdMain' => $modelAdMain,
            ]);

        } else {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        }
    }

    public function actionSelectStyle($id)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* @var $modelAdMain \common\models\AdMain */
        $modelAdMain = $this->findModel($id);

        if (Yii::$app->user->can('Автор', ['model' => $modelAdMain])) {

            if($modelAdMain->adCategory->category == 1) {
                if ($modelAdMain->load(Yii::$app->request->post()) && $modelAdMain->save()) {
                    return $this->render('complite', [
                        'modelAdMain' => $modelAdMain
                    ]);
                }
            }
        }
        throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
    }

    public function actionPublish($id)
    {
        /* @var $modelAdMain \common\models\AdMain */
        $modelAdMain = $this->findModel($id);

        if (Yii::$app->user->can('Автор', ['model' => $modelAdMain])) {

            $modelAdMain->temp = 0;
            $modelAdMain->save();

            if($modelAdMain->adCategory->adRealEstate->save()) {
                return $this->redirect(['/main/select-city', 'place' => Yii::$app->request->post('cityString')]);
            }

            return $this->render('complite', [
                'model' => $modelAdMain->adCategory->adRealEstate
            ]);

        } else {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        }
    }

    public function actionAddToComplains () {
        $id = Yii::$app->request->post('id');
        $modelAdComplain = new AdComplains();
        $modelAdComplain->addToComplains($id);

        Yii::$app->session->setFlash('error', Yii::t('app', 'The complaint was successfully added.'));

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-complain',
            [
                'id' => $id,
                'icon' => Yii::$app->request->post('icon'),
            ]);
    }

    public function actionDeleteFromComplains () {
        $id = Yii::$app->request->post('id');
        $modelAdComplain = new AdComplains();
        $modelAdComplain->deleteFromComplains($id);

        Yii::$app->session->setFlash('info', Yii::t('app', 'This ad is removed from complains.'));

        return $this->renderAjax(
            '@common/widgets/AdWidget/views/_icon-complain-empty',
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
