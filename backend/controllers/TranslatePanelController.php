<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 05.12.2015
 * Time: 10:54
 */

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\widgets\yii2TranslatePanel\models\search\SourceMessageSearch;
use common\widgets\yii2TranslatePanel\helpers\AppHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\widgets\yii2I18nModule\models\SourceMessage;


class TranslatePanelController extends BehaviorsController
{
    public function actionIndex()
    {
        return $this->render('index');
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

    public function actionRescan()
    {
        // ------------------------- RESCAN MESSAGES ---------------------------
        $result = SourceMessageSearch::getInstance()->extract();

        // ----------------------- SHOW RESCAN RESULT --------------------------
        $message  = Yii::t('app', 'Rescan successfully completed.') . '<br />';
        $message .= Html::ul([
            Yii::t('app', 'New messages:') . ' ' . (isset($result['new']) ? $result['new'] : 0),
            Yii::t('app', 'Obsolete messages:') . ' ' . (isset($result['obsolete']) ? $result['obsolete'] : 0),
        ]);
        AppHelper::showSuccessMessage($message);

        // ---------------------------- REDIRECT -------------------------------
        if ( ($referrer = Yii::$app->getRequest()->referrer) ) {
            return $this->redirect($referrer);
        } else {
            return $this->redirect(['/translate-panel']);
        }
    }

    public function actionClearCache()
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/translations']);
        }

        // ------------------ SET JSON FORMAT FOR RESPONSE ---------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // ---------------------- SET DEFAULT RESPONSE -------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('app', 'An unexpected error occured!'),
        );

        // -------------------------- CLEAR CACHE ------------------------------
        if ( SourceMessageSearch::cacheFlush() ) {
            $response['status']  = 'success';
            $response['message'] = Yii::t('app', 'Translations cache successfully cleared.');
        }

        return $response;
    }

    public function actionSave($id)
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/translations']);
        }

        // ------------------ SET JSON FORMAT FOR RESPONSE ---------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // --------------------- SET DEFAULT RESPONSE --------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('app', 'An unexpected error occured!'),
        );

        // --------------------- SAVE TRANSLATION BY ID ------------------------
        // @see vendor\zelenin\yii2-i18n-module\controllers\DefaultController::actionUpdate
        $model = $this->findModel($id);
        $model->initMessages();

        if ( Model::loadMultiple($model->messages, Yii::$app->getRequest()->post())
            && Model::validateMultiple($model->messages) )
        {
            $model->saveMessages();

            // clear translation cache
            if ( ($categories = AppHelper::getRequestParam('categories')) ) {
                foreach ( $categories as $language => $category ) {
                    Yii::$app->cache->delete([
                        'yii\i18n\DbMessageSource',
                        $category,
                        $language,
                    ]);
                }
            }

            $response['status']  = 'success';
            $response['message'] = Yii::t('app', 'Translation successfuly saved.');
            $response['params']  = AppHelper::getRequestParams();
        }

        return $response;
    }

    public function actionDelete($id)
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/translations']);
        }

        // ------------------ SET JSON FORMAT FOR RESPONSE ---------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // --------------------- SET DEFAULT RESPONSE --------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('app', 'An unexpected error occured!'),
        );

        // -------------------- DELETE TRANSLATION BY ID -----------------------
        $model = $this->findModel($id);
        $model->message = '@@' . $model->message . '@@';
        if ( $model->save() ) {
            // clear cache
            foreach ( Yii::$app->i18n->languages as $language ) {
                Yii::$app->cache->delete([
                    'yii\i18n\DbMessageSource',
                    $model->category,
                    $language,
                ]);
            }

            // set response
            $response['status']   = 'success';
            $response['message']  = 'Translation successfully deleted.';
        }

        return $response;
    }

    public function actionRestore($id)
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/translations']);
        }

        // ------------------ SET JSON FORMAT FOR RESPONSE ---------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // --------------------- SET DEFAULT RESPONSE --------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('app', 'An unexpected error occured!'),
        );

        // -------------------- RESTORE TRANSLATION BY ID ----------------------
        $model = $this->findModel($id);
        $model->message = trim($model->message, '@@');
        if ( $model->save() ) {
            // clear cache
            foreach ( Yii::$app->i18n->languages as $language ) {
                Yii::$app->cache->delete([
                    'yii\i18n\DbMessageSource',
                    $model->category,
                    $language,
                ]);
            }

            // set response
            $response['status']   = 'success';
            $response['message']  = 'Translation successfully restored.';
        }

        return $response;
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
