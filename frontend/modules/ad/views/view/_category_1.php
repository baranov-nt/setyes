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

use common\widgets\AdWidget\AdWidget;

echo AdWidget::widget([
    'template' => false,
    'id' => $model->adCategory->adMain->id,
    'author' => Yii::$app->user->can('Автор', ['model' => $model->adCategory->adMain]),
    'main_container_class' => $model->adCategory->adMain->adStyle->main_container_class,
    'favorite' => $model->adCategory->adMain->getFavorite($model->adCategory->adMain->id),
    'favorite_icon' => $model->adCategory->adMain->adStyle->favorite_icon,
    'header' => $model->dealType->reference_name,
    'address' => $model->getAddress($model),
    'address_map' => $model->place_address_id ? true : false,
    'phone_temp_ad' => $model->adCategory->adMain->phone_temp_ad,
    'images' => $model->imagesOfObjects,
    'content' => $model->contentList,
    'quick_view_class' => $model->adCategory->adMain->adStyle->quick_view_class
]);
?>
<div class="clearfix"></div>

