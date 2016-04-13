<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2016
 * Time: 17:53
 */
/* @var $modelChatForm \frontend\models\ChatForm */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\jui\Draggable;

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
<div class="container">
    <?= Html::button('Написать сообщение',
        [
            'class' => 'btn btn-sm btn-primary',
            'onclick' => '$("#chatBlock").show();'
        ])
    ?>
</div>

<?php
Draggable::begin([
    'options' => [
        'class' => 'col-md-3 col-sm-4 col-xs-12',
        'style' => '
             position: fixed;
             bottom: 50px;
             right: 0;
            margin-right: 0;
            margin-bottom: 0;'
    ],
    'clientOptions' => [/*'grid' => [50, 20]*/],
]);
?>
    <div id="chatBlock" class="modal-content" style="display: none;">
        <div class="modal-header ui-draggable-handle" style="cursor: move;">
            <?= Html::button('×', [
                'class' => 'close',
                'onclick' => '$("#chatBlock").hide();',
            ]); ?>
            <h4 id="headerChat" class="text-center" style="">Перетащи меня</h4>
        </div>
        <div class="modal-body">
            <div id="notifications" style="max-height: 100px; height: 100px; overflow-y: scroll"></div>
            <?php Pjax::begin([
                'id' => 'modalChat',
                'enablePushState' => false,
                'timeout' => 9000
            ]); ?>
            <div id="modalChat" data-pjax-container="" data-pjax-timeout="9000">
                <?php
                $form = ActiveForm::begin([
                        'id' => 'chat-form',
                        'options' => ['data-pjax' => true],
                    ]
                );
                ?>
                <?= $form->field($modelChatForm, 'name') ?>
                <?= $form->field($modelChatForm, 'message') ?>
                <?= $form->field($modelChatForm, 'active')->checkbox() ?>
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <?php
            Pjax::end();
            ?>
        </div>
    </div>
<?php
Draggable::end();
?>
<audio id="audiotag1" src="http://www.storiesinflight.com/html5/audio/flute_c_long_01.wav" preload="auto"></audio>
