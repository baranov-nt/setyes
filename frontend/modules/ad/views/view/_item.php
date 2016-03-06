<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 06.03.2016
 * Time: 16:23
 */

/* Вывод всех продуктов */
/*
 * Принимеет следующие свойства:
 *      $modelAdMain - объект элемента
 *      $key - id элемента
 *      $index - порядковый номер элемента от 0. На каждой странице считается снова
 *      $widget - объект виджета
*/

/* @var $this yii\web\View */
/* @var $modelAdMain common\models\AdMain */

use common\widgets\AdWidget\AdWidget;

echo AdWidget::widget([
    'template' => false,
    'id' => $modelAdMain->id,
    'author' => Yii::$app->user->can('Автор', ['model' => $modelAdMain]),
    'main_container_class' => $modelAdMain->adStyle->main_container_class,
    'favorite' => $modelAdMain->getFavorite($modelAdMain->id),
    'favorite_icon' => $modelAdMain->adStyle->favorite_icon,
    'favorite_icon_empty' => $modelAdMain->adStyle->favorite_icon,
    'complain' => $modelAdMain->getComplain($modelAdMain->id),
    'complain_icon' => $modelAdMain->adStyle->complain_icon,
    'header' => $modelAdMain->getHeader(),
    'address' => $modelAdMain->getAddress(),
    'address_map' => $modelAdMain->getAddressMap(),
    'phone_temp_ad' => $modelAdMain->phone_temp_ad,
    'images' => $modelAdMain->getImagesOfObjects(),
    'content' => $modelAdMain->getContentList(),
    //'content' => $modelAdMain->adCategory->adRealEstate->contentList,
    'quick_view_class' => $modelAdMain->adStyle->quick_view_class
]);
?>
<div class="clearfix"></div>
