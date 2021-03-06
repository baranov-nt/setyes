<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 15.10.2015
 * Time: 20:22
 */
/* @var $modelName int */
/* @var $id int */
/* @var $object_id int */
/* @var $image_id int */
/* @var $images_num int */
/* @var $images_label string */
/* @var $images_temp string */
/* @var $imageSmallWidth string */
/* @var $imageSmallHeight string */
/* @var $idObject int */
/* @var $baseUrl string */
/* @var $imagePath string */
/* @var $noImage string */
/* @var $imageClass string */
/* @var $buttonDeleteClass string */
/* @var $imageContainerClass string */
/* @var $formImagesContainerClass string */

/* @var $image common\models\ImagesOfObject */
/* @var $imagesObject array */
/* @var $modelImageForm \common\widgets\ImageLoad\models\ImageForm */

use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

Pjax::begin([
    'id' => 'images-widget',
    'enablePushState' => false,
]);
?>
<div id="">
    <div class="<?= $formImagesContainerClass ?>">
        <?php
        if(isset($error) && $error != false):
            ?>
            <div class="alert-danger alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $error; ?>
            </div>
            <?php
        endif;

        if(isset($isImage) && $isImage != '0'):
            $image =  Html::img('/'.$isImage, ['class' => 'imageOut']);
        else:
            $image = Html::img($noImage, ['class' => 'imageOut']);
        endif;

        $form = ActiveForm::begin(
            [
                'action' => Url::to(['/images/autoload-image']),
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'data-pjax' => true,
                    'id' => 'image-form-'.$id,
                    //'data-pjax' => 'image-widget-'.$id,
                    'timeout' => '7000'
                ]
            ]);

        echo $form->field($modelImageForm, 'image', [
            'template' => '<div id="crop-url-'.$id.'" class="btn-file">
    {input}</div>'])
            ->input('file', [
                'onchange' => 'loadFile(event)',
            ])->label(false)->error(false);
        ?>

        <?php
        foreach($imagesObject as $image):
            ?>
            <div class="<?= $imageContainerClass; ?>">
                <?php
                echo Html::button('', [
                    'class' => $buttonDeleteClass,
                    'onClick' => "
            window.idImage = '".$image->image->id."';
            deleteImage(event);
            "
                ]);

                echo Html::img($baseUrl.$image->image->path_small_image, ['class' => $imageClass, 'onclick' => "
            window.idImage = '".$image->image->id."';
            $('#imageform-image').click();"
                ]);
                ?>
            </div>
            <?php
        endforeach;

        $numObjects = count($imagesObject);

        if($numObjects < $images_num):
            ?>
            <div class="<?= $imageContainerClass; ?>">
                <?php
                echo Html::img($baseUrl.$noImage, ['class' => $imageClass, 'onclick' => "
            window.idImage = 0;
            $('#imageform-image').click();"
                ]);
                ?>
            </div>
            <?php
        endif;
        echo Html::input('hidden', 'imageData[modelName]', $modelName);
        echo Html::input('hidden', 'imageData[id]', $id);
        echo Html::input('hidden', 'imageData[object_id]', $object_id);
        echo Html::input('hidden', 'imageData[image_id]', null, ['id' => 'image_id-'.$id]);
        echo Html::input('hidden', 'imageData[images_num]', $images_num);
        echo Html::input('hidden', 'imageData[images_label]', $images_label);
        echo Html::input('hidden', 'imageData[images_temp]', $images_temp);
        echo Html::input('hidden', 'imageData[imageSmallWidth]', $imageSmallWidth);
        echo Html::input('hidden', 'imageData[imageSmallHeight]', $imageSmallHeight);
        echo Html::input('hidden', 'imageData[baseUrl]', $baseUrl);
        echo Html::input('hidden', 'imageData[imagePath]', $imagePath);
        echo Html::input('hidden', 'imageData[noImage]', $noImage);
        echo Html::input('hidden', 'imageData[imageCrop]', null, ['id' => 'imageCrop-'.$id]);
        echo Html::input('hidden', 'imageData[imageClass]', $imageClass);
        echo Html::input('hidden', 'imageData[buttonDeleteClass]', $buttonDeleteClass);
        echo Html::input('hidden', 'imageData[imageContainerClass]', $imageContainerClass);
        echo Html::input('hidden', 'imageData[formImagesContainerClass]', $formImagesContainerClass);
        ActiveForm::end();
        ?>
    </div>
</div>
<?php
//dd(1);
Pjax::end();
