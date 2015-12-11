<?php

namespace common\widgets\yii2TranslatePanel\components\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public function init()
    {
        $this->header = $this->header ?: Yii::t('app', 'Actions');
        $this->footer = $this->footer ?: Yii::t('app', 'Actions');
        $this->headerOptions = ArrayHelper::merge([
            'class' => 'text-align-center',
            'width' => '100',
        ], $this->headerOptions);
        $this->footerOptions = ArrayHelper::merge([
            'class' => 'text-align-center font-weight-bold th',
        ], $this->footerOptions);
        $this->contentOptions = ArrayHelper::merge([
            'class' => 'text-align-center nowrap',
        ], $this->contentOptions);

        parent::init();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'class'     => 'btn btn-xs btn-default',
                    'title'     => Yii::t('app', 'View'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'class'     => 'btn btn-xs btn-default',
                    'title'     => Yii::t('app', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if ( !isset($this->buttons['save']) ) {
            $this->buttons['save'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-download"></span> ' . Yii::t('app', 'Save'), $url, [
                    'class'     => 'btn btn-xs btn-success',
                    'title'     => Yii::t('app', 'Save'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'class'         => 'btn btn-xs btn-danger margin-left-10px',
                    'title'         => Yii::t('app', 'Delete'),
                    'data-confirm'  => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'data-method'   => 'post',
                    'data-pjax'     => '0',
                ]);
            };
        }

    }
}
