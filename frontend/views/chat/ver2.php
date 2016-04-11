<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2016
 * Time: 17:53
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
    /*.modal
    {
        overflow: hidden !important;
        z-index: 0 !important;
    }
    .modal-dialog{
        position: fixed;
        right: 0;
        bottom: 0;
        z-index: 1;
    }*/
</style>
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
</div>
