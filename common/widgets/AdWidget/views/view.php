<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 16.02.2016
 * Time: 11:32
 */
/* @var $widget \common\widgets\AdWidget\AdWidget */
/* @var $user common\models\User */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use yii\widgets\Pjax;

Pjax::widget();
/*$js=<<<JS
$("#id_$this->id").on("pjax:complete", function() {
    $("#id_$this->id").attr("tabindex",-1).focus();
 });
JS;
$this->registerJS($js);*/
?>

<div id="id_<?= $widget->id ?>" class="main-container-element <?= $widget->main_container_class ?>" style="outline: none;">
    <div class="row">
        <div class="col-xs-12">
            <?= Html::tag('span', '', [
                'class' => $widget->favorite_icon.' icon-favorite',
                'onclick' => '$.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/favorite']).'",
                    container: "#id_'.$widget->id.'",
                    push: false
                })'
            ]) ?>
            <?php
            if($widget->template):
                ?>
                <h4 class="main-container-header-element-template"><?= Yii::t('references', $widget->header) ?></h4>
                <?php
            else:
                ?>
                <h4 class="main-container-header-element"><?= Html::a(Yii::t('references', $widget->header), Url::to(['/ad/view/one', 'id' => $widget->id]), ['class' => 'main-container-header-link-element alert-link']) // операция ?></h4>
                <?php
            endif;
            ?>
        </div>
        <div class="col-xs-12">
            <p><?= $widget->address ?></p>
        </div>
        <?php
        if($widget->images):
            ?>
            <div class="col-xs-12 block-padding-bottom">
                <?php
                if(count($widget->images) > 1):
                    echo Carousel::widget([
                        'items' => $items,
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
                ?>
            </div>
            <?php
        endif;
        ?>
        <div class="col-xs-12">
            <?= $widget->content ?>
        </div>
        <div class="col-xs-12">
            <i class="fa fa-mobile fa-2x"></i>
            <h5><?= $user->phone ?></h5>
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
        <div class="col-xs-12">
            <?= Html::button(Yii::t('app', 'Quick view'), ['class' => $widget->quick_view_class, 'style' => 'width: 100%;']) ?>
        </div>
    </div>
</div>
<?php
