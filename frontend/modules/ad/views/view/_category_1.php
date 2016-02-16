<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 13:50
 */

/* Вывод всех продуктов */
/*
 * Принимеет следующие свойства:
 *      $model - объект элемента
 *      $key - id элемента
 *      $index - порядковый номер элемента от 0. На каждой странице считается снова
 *      $widget - объект виджета
*/

/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $one common\models\ImagesOfObject */

use common\widgets\AdWidget\AdWidget;

echo AdWidget::widget([
    'template' => true,
    'main_container_class' => $model->adCategory->adMain->adStyle->main_container_class,
    'favorite_icon' => $model->adCategory->adMain->adStyle->favorite_icon,
    'header' => $model->dealType->reference_name,
    'address' => $model->getAddress($model),
    'images' => $model->imagesOfObjects,
    'content' => $model->contentList,
    'quick_view_class' => $model->adCategory->adMain->adStyle->quick_view_class
]);
?>


