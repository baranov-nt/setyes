<?php

namespace common\widgets\ScrollToTop;

use yii\helpers\Html;

class ScrollToTop extends \yii\base\Widget
{
    public $isRegistered = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $bandles = $this->view->assetManager->bundles;
        $this->isRegistered = isset($bandles['common\\widgets\\AssetBundle']);
        AssetBundle::register($this->view);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ( false === $this->isRegistered ) {
            return Html::a('', null, [
                'class' => 'scroll-to-top-link',
                'style' => 'display: none;',
                'href'  => '#wrapper',
            ]);
        }
    }
}
