<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 17.02.2016
 * Time: 9:52
 */
/** @var $id integer
 *  @var $ok integer
 *  @var $icon string */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="favorite_container_<?= $id ?>" style="outline: none;">
    <?= \common\widgets\AlertIGrowl::widget() ?>
    <?php
    $js=<<<JS
$("#favorite_container_$id").on("pjax:complete", function() {
    $("#icon-favorite-id-$id").attr("tabindex",-1).focus();
 });
JS;
    $this->registerJS($js);
    ?>

    <?= Html::tag('span', '', [
        'class' => 'icon-favorite '.$icon,
        'id' => 'icon-favorite-id-'.$id,
        'style' => 'outline: none;',
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'title' => Yii::t('app', 'Remove from favorites'),
        'onclick' => '$.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/delete-from-favorites']).'",
                    container: "#favorite_container_'.$id.'",
                    data: {id: '.$id.', icon: "'.$icon.'"},
                    push: false
                })'
    ]);
    ?>
</div>
