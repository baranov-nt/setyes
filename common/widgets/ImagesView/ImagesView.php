<?php

/**
 * Created by phpNT.
 * User: phpNT
 * Date: 15.02.2016
 * Time: 13:23
 */

namespace common\widgets\ImagesView;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class ImagesView extends Widget
{
    public $model;
    public $images;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if(count($this->model->imagesOfObjects) > 1):
            $this->images = $this->model->adCategory->adMain->getImages($this->model);
        else:
            /* Если одно изоражение */
            foreach($this->model->imagesOfObjects as $one):
                $this->images =  Html::img('/images/'.$one->image->path_small_image, [
                    'style' => 'width: 100%'
                ]);
            endforeach;
        endif;

        return $this->render(
            'images',
            [
                'widget' => $this
            ]);
    }
}