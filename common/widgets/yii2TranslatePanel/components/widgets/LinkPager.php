<?php

namespace common\widgets\yii2TranslatePanel\components\widgets;

use Yii;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * Initializes the pager.
     */
    public function init()
    {
        $this->nextPageLabel  = Yii::t('app', 'Next') . ' &raquo;';
        $this->prevPageLabel  = '&laquo; ' . Yii::t('app', 'Prev.');
        $this->firstPageLabel = Yii::t('app', 'First');
        $this->lastPageLabel  = Yii::t('app', 'Last');

        parent::init();
    }
}
