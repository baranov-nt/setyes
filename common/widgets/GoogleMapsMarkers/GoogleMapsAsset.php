<?php

namespace common\widgets\GoogleMapsMarkers;

use yii\web\AssetBundle;

/**
 * Class GoogleMapsAsset
 * @package yii2mod\google\maps\markers
 */
class GoogleMapsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/GoogleMapsMarkers/assets';

    /**
     * @var array
     */
    public $js = [
        'markerclusterer_compiled.js',
        'googlemap.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
