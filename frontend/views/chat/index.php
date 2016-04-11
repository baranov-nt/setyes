<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2016
 * Time: 18:03
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use common\widgets\Draggable\AssetBundle;
use yii\jui\Draggable;


/* @var $this yii\web\View */
/* @var $modelChatForm frontend\models\ChatForm */
//AssetBundle::register($this);


$this->title = 'Чат Node JS + Redis';


/*$this->registerCss("
.modal
{
    overflow: hidden !important;
}
.modal-dialog{
    position: absolute;
    right: 0;
    bottom: 0;
}
 ");*/
/*$js = <<<JS
JS;
$this->registerJs($js, \yii\web\View::POS_READY)*/
$script = <<< JS
    $('.modal.draggable>.modal-dialog').draggable({
        cursor: 'move',
        handle: '.modal-header'
    });
$('.modal.draggable>.modal-dialog>.modal-content>.modal-header').css('cursor', 'move');
        $("document").ready(function(){
            $("#modalChat").on('pjax:send', function() {
                
            });
            $("#modalChat").on('pjax:complete', function() {
                $("#myChatModal").modal("show");
            });
        });
JS;
$this->registerJs($script);
?>
<style>
    .modal
    {
        overflow: hidden !important;
        z-index: 0 !important;
    }
    .modal-dialog{
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: 1;
    }
</style>
<div class="container">
    <?= Html::button('Написать сообщение',
        [
            'class' => 'btn btn-sm btn-primary',
            'data-toggle' => 'modal',
            'data-target' => '#myChatModal'
        ])
    ?>

    <?php
    Draggable::begin([
        'clientOptions' => ['grid' => [50, 20]],
    ]);
    Modal::begin([
        'size' => 'modal-sm',
        'id' => 'myChatModal',
        'header' => '<h4 class="text-center" style="">Перетащи меня</h4>',
        'headerOptions' => [
            'style' => 'cursor: move;'
        ],
        'toggleButton' => false,
        'clientOptions' => ['backdrop' => false, 'keyboard' => false],
        'options' => [
            'class' => 'draggable'
        ]
    ]);
    ?>
    <div id="notifications"></div>
    <?php Pjax::begin([
        'id' => 'modalChat',
        'enablePushState' => false,
        'timeout' => 9000
    ]); ?>
    <?php
    $form = ActiveForm::begin([
            'id' => 'chat-form',
            'options' => ['data-pjax' => true],
        ]
    );
    ?>
    <?= $form->field($modelChatForm, 'name') ?>
    <?= $form->field($modelChatForm, 'message') ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
    <?php
    Pjax::end();
    ?>
    <?php
    Modal::end();
    Draggable::end();
    ?>
</div>

