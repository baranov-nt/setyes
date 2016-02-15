<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 15.02.2016
 * Time: 13:25
 */
/* @var $widget \common\widgets\ImagesView\ImagesView */

use yii\bootstrap\Carousel;

if(count($widget->images) > 1):
    echo Carousel::widget([
        'items' => $widget->images,
        'options' => [
            'data-interval' => 0,
            'class' => 'slide',
            'style' => 'width:100%;' // set the width of the container if you like
        ],
        'controls' => ['&lsaquo;', '&rsaquo;'],     // Стрелочки вперед - назад
        //'controls' => ['<', '>'],                     // Стрелочки вперед - назад
        'showIndicators' => true,                   // отображать индикаторы (кругляшки)

    ]);
else:
    echo $widget->images;
endif;