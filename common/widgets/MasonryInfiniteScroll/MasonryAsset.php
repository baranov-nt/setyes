<?php

/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 18:24
 */
namespace common\widgets\MasonryInfiniteScroll;

use yii\web\AssetBundle;

class MasonryAsset extends AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/masonry';

    /**
     * @inherit
     */
    public $js = [
        'dist/masonry.pkgd.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}