<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 18.02.2016
 * Time: 0:52
 */
/* @var $modalWindow bool */
/* @var $id integer */
/* @var $header string */
/* @var $address string */
/* @var $address_map integer */
/* @var $phone_temp_ad string */
/* @var $items array */
/* @var $content array */
/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $user common\models\User */

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('references', $header).' '.$address;

use yii\bootstrap\Carousel;
use common\widgets\ShowMapModal\ShowMapModal;
use common\widgets\iGrowl\AssetBundle;

AssetBundle::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="padding-left: 20px !important;">
                <h1 class="text-uppercase"><?= Yii::t('references', $header) ?></h1><p><?= $address ?></p>
            </div>
        </div>
        <div class="col-md-12">
            <?php
            if($items):
                ?>
                <div class="col-xs-12 block-padding-bottom">
                    <?php
                    if(count($items) > 1):
                        echo Carousel::widget([
                            'items' => $items,
                            'options' => [
                                //'data-interval' => 0,
                                'class' => 'slide',
                                'style' => 'width:100%;' // set the width of the container if you like
                            ],
                            'controls' => ['&lsaquo;', '&rsaquo;'],     // Стрелочки вперед - назад
                            //'controls' => ['<', '>'],                     // Стрелочки вперед - назад
                            'showIndicators' => true,                   // отображать индикаторы (кругляшки)

                        ]);
                    else:
                        echo $items;
                    endif;
                    ?>
                </div>
                <?php
            endif;
            ?>
        </div>
        <div class="col-md-6">
            <div class="col-xs-12">
                <?= $content ?>
            </div>
            <div class="col-xs-12">
                <?php
                if($phone_temp_ad):
                    ?>
                    <i class="fa fa-mobile fa-2x"></i>
                    <h5><?= $phone_temp_ad ?></h5>
                    <?php
                else:
                    ?>
                    <i class="fa fa-mobile fa-2x"></i>
                    <h5><?= $user->phone ?></h5>
                    <?php
                endif;
                ?>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-envelope-o fa-2x"></i>
                <h5><?= $user->email ?></h5>
            </div>
            <?php
            if($user->userProfile->first_name || $user->userProfile->second_name):
                ?>
                <div class="col-xs-12">
                    <i class="fa fa-user fa-2x" style=""></i>
                    <h5><?= $user->userProfile->first_name.' '.$user->userProfile->second_name ?></h5>
                </div>
                <?php
            endif;
            ?>
        </div>
        <div class="col-md-6" style="padding: 0 30px 20px 30px;">
            <?php if($address_map): ?>
                <?= ShowMapModal::widget([
                    'modal' => false,
                    'address' => $address,
                ]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
