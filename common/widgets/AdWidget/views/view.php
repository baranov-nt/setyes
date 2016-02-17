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
use yii\bootstrap\Modal;

Modal::begin([
    'size' => 'modal-sm text-center',
    'header' => '<h5>'.Yii::t('app', 'Do you want to delete the ad?').'</h5>',
    'toggleButton' => false,
    'closeButton' => false,
    'id' => 'delete-element-'.$widget->id,
]);

echo Html::button(Yii::t('app', 'Yes'),
    [
        'class' => 'btn btn-danger',
        'style' => 'margin-right: 5px;',
        'onclick' => '
        $("#delete-element-'.$widget->id.'").modal("hide");
        $.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/delete']).'",
                    container: "#element_container_'.$widget->id.'",
                    data: {id: '.$widget->id.'},
                    push: false
                })
    '
    ]);
echo Html::button(Yii::t('app', 'No'), ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'aria-hidden' => 'true', 'style' => 'margin-left: 5px;']);

Modal::end();

Pjax::widget();
$js=<<<JS
$("#star_container_$widget->id").on("pjax:complete", function() {
    $("#star_container_$widget->id").attr("tabindex",-1).focus();
 });
JS;
$this->registerJS($js);
?>

<div id="element_container_<?= $widget->id ?>" class="main-container-element <?= $widget->main_container_class ?>">
    <div class="row">
        <div class="col-xs-12">
            <div id="star_container_<?= $widget->id ?>" style="outline: none;">
                <?php
                if($widget->template):
                    ?>
                    <?= Html::tag('span', '',
                    [
                        'class' => 'icon-favorite-empty glyphicon glyphicon-star',
                        'title' => Yii::t('app', 'Add to favorites'),
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                    ]) ?>
                    <?php
                else:
                    if($widget->author):
                    ?>
                        <?php
                        echo Html::tag('span', '',
                            [
                                'class' => 'icon-trash glyphicon glyphicon-trash',
                                'title' => Yii::t('app', 'Edit ad'),
                                'data-toggle' => 'modal',
                                'data-target' => '#delete-element-'.$widget->id,
                            ]);
                        ?>
                        <a href="<?= Url::to(['/ad/view/update', 'id' => $widget->id]) ?>">
                            <?php
                            echo Html::tag('span', '',
                                [
                                    'class' => 'icon-pencil glyphicon glyphicon-pencil',
                                    'title' => Yii::t('app', 'Remove ad'),
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                ]);
                            ?>
                        </a>
                    <?php
                    else:
                        if ($widget->favorite) {
                            echo $this->render('_icon-favorite', [
                                'id' => $widget->id,
                                'icon' => $widget->favorite_icon,
                                'ok' => null
                            ]);
                        } else {
                            echo $this->render('_icon-favorite-empty', [
                                'id' => $widget->id,
                                'icon' => $widget->favorite_icon,
                                'ok' => null
                            ]);
                        }
                    endif;
                endif;
                ?>
            </div>
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
        <!--<div class="col-xs-12">
            <i class="fa fa-envelope-o fa-2x"></i>
            <h5><?/*= $user->email */?></h5>
        </div>-->
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
            <?= Html::button(Yii::t('app', 'Quick view'),
                [
                    'id' => 'button-open-modal-'.$widget->id,
                    'class' => $widget->quick_view_class,
                    'style' => 'width: 100%;',
                    'onclick' => '
                    $.pjax({
                        type: "POST",
                        url: "'.Url::to(['/ad/view/open-in-modal']).'",
                        container: "#modal-block",
                        data: {id: '.$widget->id.'},
                        push: false
                    })
                    '
                ]) ?>
        </div>
    </div>
</div>
<?php
