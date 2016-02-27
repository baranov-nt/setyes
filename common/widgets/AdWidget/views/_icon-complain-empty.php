<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 23.02.2016
 * Time: 14:48
 */
/** @var $id integer
 *  @var $ok integer
 *  @var $icon string */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="complain_container_<?= $id ?>" style="outline: none;">
    <?= \common\widgets\AlertIGrowl::widget() ?>
    <?php
    $js=<<<JS
$("#complain_container_$id").on("pjax:complete", function() {
    $("#icon-complain-id-$id").attr("tabindex",-1).focus();
 });
JS;
    $this->registerJS($js);
    ?>
    <?= Html::tag('span', '', [
        'class' => 'icon-exclamation-sign-empty '.$icon,
        'id' => 'icon-complain-id-'.$id,
        'style' => 'outline: none;',
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'title' => Yii::t('app', 'Complain about this ad'),
        'onclick' => '$.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/add-to-complains']).'",
                    container: "#complain_container_'.$id.'",
                    data: {id: '.$id.', icon: "'.$icon.'"},
                    push: false
                })'
    ]);
    ?>
</div>


