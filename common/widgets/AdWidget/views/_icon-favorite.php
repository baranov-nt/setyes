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
$js=<<<JS
$("#star_container_$id").on("pjax:complete", function() {
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
                    container: "#star_container_'.$id.'",
                    data: {id: '.$id.', icon: "'.$icon.'"},
                    push: false
                })'
]);
if($ok == 1)
    Yii::$app->view->registerJs('
            $.iGrowl({
                type: "notice",
                message: "'.Yii::t('app', 'Ad added to favorites.').'",
                offset : {
                    y: 	80
                }
            });
        ');
?>

