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
/* @var $main_container_class string */
/* @var $background_color string */
/* @var $text_color string */
/* @var $address_map integer */
/* @var $phone_temp_ad string */
/* @var $items array */
/* @var $content array */
/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $user common\models\User */

use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\bootstrap\Carousel;
use common\widgets\ShowMapModal\ShowMapModal;

Pjax::begin([
    'id' => 'modal-block'
]);
if(isset($modalWindow)):
    $js=<<<JS
    $("#modal-block").on("pjax:complete", function() {
        $("#button-open-modal-$id").attr("tabindex",-1).focus();
     });
JS;
    $this->registerJS($js);

    $js=<<<JS
        $("#myMapModal").modal("show");
        $("#myMapModal .modal-content").addClass("$main_container_class");
        $(".modal-content").css("background-color", "$background_color");
        $(".modal-header").css("border-color", "$text_color");
JS;
$this->registerJS($js);
Modal::begin([
    'size' => 'modal-lg',
    'id' => 'myMapModal',
    'header' => '<div class="" style="padding-left: 20px;"><h1 class="text-uppercase" style="margin-top: 0;">'.Yii::t('references', $header).'</h1><p>'.$address.'</p></div>',
    'toggleButton' => false
]);
?>
<div class="row">
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
                <i class="fa fa-user fa-2x"></i>
                <h5><?= $user->userProfile->first_name.' '.$user->userProfile->second_name ?></h5>
            </div>
            <?php
        endif;
        ?>
    </div>
    <?php if($address_map): ?>

    <div class="col-md-6" style="padding: 0 30px 20px 30px;">
        <div style="border: 1px solid <?= $text_color ?>; border-radius: 3px">
            <?= ShowMapModal::widget([
                'modal' => true,
                'address' => $address,
            ]); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-12">
        <?php
        if($items):
            ?>
            <div class="col-xs-12 block-padding-bottom">
                <?php
                if(count($items) > 1):
                    echo Carousel::widget([
                        'id' => 'carouser-modal-'.$id,
                        'items' => $items,
                        'options' => [
                            'data-interval' => 0,
                            'class' => 'slide',
                            'style' => 'width:100%;'
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

</div>
<?php
Modal::end();


endif;
Pjax::end();

