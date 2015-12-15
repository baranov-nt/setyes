<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\widgets\yii2I18nModule\models\search\SourceMessageSearch;
use common\widgets\yii2I18nModule\models\SourceMessage;

class TranslateController extends BehaviorsController
{
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch;
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        /** @var SourceMessage $model */
        $model = $this->findModel($id);
        $model->initMessages();

        if (Model::loadMultiple($model->messages, Yii::$app->getRequest()->post()) && Model::validateMultiple($model->messages)) {
            $model->saveMessages();
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Updated'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * @param array|integer $id
     * @return SourceMessage|SourceMessage[]
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $query = SourceMessage::find()->where('id = :id', [':id' => $id]);
        $models = is_array($id)
            ? $query->all()
            : $query->one();
        if (!empty($models)) {
            return $models;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
        }
    }
}
