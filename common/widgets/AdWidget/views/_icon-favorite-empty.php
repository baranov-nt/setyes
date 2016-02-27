<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 17.02.2016
 * Time: 10:24
 */
/** @var $id integer
 *  @var $ok integer
 *  @var $icon string */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= \common\widgets\AlertIGrowl::widget() ?>
<div id="favorite_container_<?= $id ?>" style="outline: none;">
    <?php
    $js=<<<JS
$("#favorite_container_$id").on("pjax:complete", function() {
    $("#icon-favorite-id-$id").attr("tabindex",-1).focus();
 });
JS;
    $this->registerJS($js);
    ?>
    <?= Html::tag('span', '', [
        'class' => 'icon-favorite-empty '.$icon,
        'id' => 'icon-favorite-id-'.$id,
        'style' => 'outline: none;',
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'title' => Yii::t('app', 'Add to favorites'),
        'onclick' => '$.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/add-to-favorites']).'",
                    container: "#favorite_container_'.$id.'",
                    data: {id: '.$id.', icon: "'.$icon.'"},
                    push: false
                })'
    ]);
    ?>
</div>


