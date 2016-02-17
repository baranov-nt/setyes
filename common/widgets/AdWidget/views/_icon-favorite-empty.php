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
use common\widgets\iGrowl\IGrowlWidget;

$js=<<<JS
$("#star_container_$id").on("pjax:complete", function() {
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
                    container: "#star_container_'.$id.'",
                    data: {id: '.$id.', icon: "'.$icon.'"},
                    push: false
                })'
]);
if($ok == 1)
    Yii::$app->view->registerJs('
            $.iGrowl({
                type: "info",
                message: "'.Yii::t('app', 'This ad is removed from your favorites.').'",
                offset : {
                    y: 	80
                }
            });
        ');



