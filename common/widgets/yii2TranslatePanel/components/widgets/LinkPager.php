<?php

namespace common\widgets\yii2TranslatePanel\components\widgets;

use common\widgets\yii2TranslatePanel\Module;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * Initializes the pager.
     */
    public function init()
    {
        $this->nextPageLabel  = Module::t('Next') . ' &raquo;';
        $this->prevPageLabel  = '&laquo; ' . Module::t('Prev.');
        $this->firstPageLabel = Module::t('First');
        $this->lastPageLabel  = Module::t('Last');

        parent::init();
    }
}
