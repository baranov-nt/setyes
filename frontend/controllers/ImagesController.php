<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.10.2015
 * Time: 11:09
 */
namespace frontend\controllers;

use common\models\AdRealEstate;
use common\models\UserProfile;
use Yii;
use common\widgets\ImageLoad\ImageLoadWidget;
use yii\helpers\Json;
use common\widgets\ImageLoad\models\ImageForm;
use yii\web\Controller;

class ImagesController extends Controller
{
    public $titleMeta = 'Бояр';
    public $siteNameMeta = 'Бояр';
    public $descriptionMeta = 'Заказ продуктов питания.';
    public $imageMeta = 'logo.jpg';
    public $urlMeta = '';
    public $appFbIdMeta = '618854251589299';

    public function actionAutoloadImage()
    {

        //dd(Yii::$app->request->get());
        if(Yii::$app->request->isPjax) {
            /*d($_FILES);
            d(Yii::$app->request->get());
            dd(Yii::$app->request->post());*/
        $imageData = Yii::$app->request->post('imageData');
        //$imageData = Yii::$app->request->get('imageData');
        $modelImageForm = new ImageForm();
        if($imageData['image_id'] == '0'):
            $modelImageForm->createImage();
        else:
            $modelImageForm->updateImage();
        endif;
        if(Yii::$app->session->get('error')):
            $error = Yii::$app->session->get('error');
        else:
            $error = false;
        endif;
        /* @var $model \common\models\AdRealEstate */
        if($imageData['modelName'] == 'AdRealEstate'):

            $model = AdRealEstate::findOne($imageData['object_id']);
            //d($model);
        elseif($imageData['modelName'] == 'UserProfile'):
            $model = UserProfile::findOne($imageData['object_id']);
            //d($model);
        endif;
        $imagesObject = $model->imagesOfObjects;
        //d($model->imagesOfObjects);
        return $this->render(
            '@common/widgets/ImageLoad/views/_formAutoload',
            [
                'modelName' => $imageData['modelName'],
                'id' => $imageData['id'],
                'object_id' => $imageData['object_id'],
                'images_num' => $imageData['images_num'],
                'images_label' => $imageData['images_label'],
                'images_temp' => $imageData['images_temp'],
                'imageSmallWidth' => $imageData['imageSmallWidth'],
                'imageSmallHeight' => $imageData['imageSmallHeight'],
                'imagesObject' => $imagesObject,
                'modelImageForm' => $modelImageForm,
                'baseUrl' => $imageData['baseUrl'],
                'imagePath' => $imageData['imagePath'],
                'noImage' => $imageData['noImage'],
                'imageClass' => $imageData['imageClass'],
                'buttonDeleteClass' => $imageData['buttonDeleteClass'],
                'imageContainerClass' => $imageData['imageContainerClass'],
                'formImagesContainerClass' => $imageData['formImagesContainerClass'],
                'error' => $error,
            ]
        );
        } else {
            d($_FILES);
            d(Yii::$app->request->get());
            dd(Yii::$app->request->post());
            /*dd([Yii::$app->session->get('tempId')]);
            $model = AdRealEstate::findOne(Yii::$app->session->get('tempId'));
            $imagesObject = $model->imagesOfObjects;
            $modelImageForm = new ImageForm();
            return $this->render(
                '@common/widgets/ImageLoad/views/_formAutoload',
                [
                    'modelName' => $imageData['modelName'],
                    'id' => $imageData['id'],
                    'object_id' => $imageData['object_id'],
                    'images_num' => $imageData['images_num'],
                    'images_label' => $imageData['images_label'],
                    'images_temp' => $imageData['images_temp'],
                    'imageSmallWidth' => $imageData['imageSmallWidth'],
                    'imageSmallHeight' => $imageData['imageSmallHeight'],
                    'imagesObject' => $imagesObject,
                    'modelImageForm' => $modelImageForm,
                    'baseUrl' => $imageData['baseUrl'],
                    'imagePath' => $imageData['imagePath'],
                    'noImage' => $imageData['noImage'],
                    'imageClass' => $imageData['imageClass'],
                    'buttonDeleteClass' => $imageData['buttonDeleteClass'],
                    'imageContainerClass' => $imageData['imageContainerClass'],
                    'formImagesContainerClass' => $imageData['formImagesContainerClass'],
                    'error' => $error,
                ]
            );*/
            //return $this->redirect(['/ad/real-estate/create']);
        }
    }
    /**
     * @return string
     */
    public function actionDeleteAvatar()
    {
        $imageData = Json::decode(Yii::$app->request->post('imageData'));
        $modelImageForm = new ImageForm();
        $modelImageForm->deleteImage();
        if(Yii::$app->session->get('error')):
            echo $error = Yii::$app->session->get('error');
        else:
            $error = false;
        endif;
        /* @var $model \common\models\AdRealEstate */
        if($imageData['modelName'] == 'AdRealEstate'):
            $model = AdRealEstate::findOne($imageData['object_id']);
        elseif($imageData['modelName'] == 'UserProfile'):
            $model = UserProfile::findOne($imageData['object_id']);
        endif;

        $imagesObject = $model->imagesOfObjects;
        return $this->render(
            '@common/widgets/ImageLoad/views/_formAutoload',
            [
                'modelName' => $imageData['modelName'],
                'id' => $imageData['id'],
                'object_id' => $imageData['object_id'],
                'images_num' => $imageData['images_num'],
                'images_label' => $imageData['images_label'],
                'images_temp' => $imageData['images_temp'],
                'imageSmallWidth' => $imageData['imageSmallWidth'],
                'imageSmallHeight' => $imageData['imageSmallHeight'],
                'imagesObject' => $imagesObject,
                'modelImageForm' => $modelImageForm,
                'baseUrl' => $imageData['baseUrl'],
                'imagePath' => $imageData['imagePath'],
                'noImage' => $imageData['noImage'],
                'imageClass' => $imageData['imageClass'],
                'buttonDeleteClass' => $imageData['buttonDeleteClass'],
                'imageContainerClass' => $imageData['imageContainerClass'],
                'formImagesContainerClass' => $imageData['formImagesContainerClass'],
                'error' => $error,
            ]
        );
    }
}