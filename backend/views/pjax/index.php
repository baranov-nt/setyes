<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.03.2016
 * Time: 20:16
 */
/* @var $time string */
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use common\widgets\PjaxWidgetForm\PjaxWidgetForm;
use common\widgets\FontAwesome\AssetBundle;

AssetBundle::register($this);
?>
<h1>Pjax средстами Yii2</h1>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin([
        'id' => 'pjax-widget-form',
        // enablePushState - не меняет ссылку при получении данных
        'enablePushState' => false
    ]); ?>
    <?php
    if(isset($modelProfile)):
        ?>
        <?= PjaxWidgetForm::widget([
        'modelProfile' => $modelProfile
    ]); ?>
        <?php
    else:
        ?>
            <?= PjaxWidgetForm::widget([]); ?>
        <?php
    endif;
    ?>
    <?php Pjax::end(); ?>
</div>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin([
        'id' => 'pjax-block-form',
        // enablePushState - не меняет ссылку при получении данных
        'enablePushState' => false
    ]); ?>
    <h3 style="text-decoration: underline">Изменение элемента с помощью формы</h3>
    <h1>Отчество</h1>
    <?php
    if(isset($modelProfile)):
        ?>
        <?php $form = ActiveForm::begin([
        'action' => 'update-middle-name',
        'id' => 'pjax-form',
        'options' => ['data-pjax' => true]
    ]); ?>
        <?= $form->field($modelProfile, 'middle_name') ?>
        <?= Html::submitButton(Yii::t('app', 'Сохранить отчество'), ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>
        <?php
    else:
    ?>
        <?php
        if(isset($middleName)):
            ?>
            <p><?= $middleName ?></p>
            <?php
        endif;
        ?>
        <?= Html::a("Изменить отчество", ['/pjax/show-middle-name'], ['class' => 'btn btn-sm btn-primary']);?>
        <?= Html::a("Удалить отчество", ['/pjax/delete-middle-name'], ['class' => 'btn btn-sm btn-danger']);?>
        <?php
    endif;
    ?>
    <?php Pjax::end(); ?>
</div>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin([
        // enablePushState - не меняет ссылку при получении данных
        'enablePushState' => false
    ]); ?>
    <h3 style="text-decoration: underline">Автоматическое обновление блока без изменения Url</h3>
    <h1>Сейчас:
        <?php
        if(isset($time)):
            ?>
            <?= $time ?>
            <?php
        endif;
        ?>
    </h1>
    <?= Html::a("Получить время с сервера", ['/pjax/get-time'], [
        'id' => 'refreshButton',
        'class' => 'btn btn-sm btn-success',
        'style' => 'display: none'
    ]);?>

    <?php Pjax::end(); ?>
    <?php
    /*$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#refreshButton").click(); }, 1000);
});
JS;
    $this->registerJs($script);*/
    ?>
</div>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin([
        //'timeout' => 9000,
        // enablePushState - не меняет ссылку при получении данных
        'id' => 'pjax-events',
        'enablePushState' => false
    ]); ?>
    <h3 style="text-decoration: underline">События Pjax</h3>
    <h1>Сейчас:
        <?php
        if(isset($time)):
            ?>
            <?= $time ?>
            <?php
        endif;
        ?>
    </h1>
    <?= Html::a('Получить время с сервера <span id="loading" class="fa fa-spinner fa-spin" style="display: none;"></span>', ['/pjax/get-time'], [
        'class' => 'btn btn-sm btn-success',
    ]);?>
    <?php Pjax::end(); ?>
    <?php
    $script = <<< JS
        $("document").ready(function(){
            $("#pjax-events").on("pjax:start", function() {
                //alert('Начало обновления');
            });
            $("#pjax-events").on("pjax:end", function() {
                //alert('Конец обновления');
            });
            /*$("#pjax-events").on('pjax:complete', function() {
                $.pjax.reload({container:"#gettime"});
            })*/
            /* События с отображением анимации загрузки */
            $("#pjax-events").on('pjax:send', function() {
                $('#loading').show();
            });
            $("#pjax-events").on('pjax:complete', function() {
                $('#loading').hide();
            });
            /* Обновление другого блока после загрузки первого */
            $("#pjax-events").on("pjax:end", function() {
                $.pjax.reload({
                    type       : 'GET',
                    url        : 'get-time',
                    container  : '#notes',
                    data       : {},
                    push       : false,
                    replace    : false,
                    timeout    : 10000,
                    "scrollTo" : false
                });
            });
        });
JS;
    $this->registerJs($script);
    ?>
</div>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin([
        'id' => 'notes',
        // enablePushState - не меняет ссылку при получении данных
        'enablePushState' => false
    ]); ?>
    <h3 style="text-decoration: underline">Обновление блока без изменения Url</h3>
    <h1>Сейчас:
        <?php
        if(isset($time)):
            ?>
            <?= $time ?>
            <?php
        endif;
        ?>
    </h1>
    <?= Html::a("Получить время с сервера", ['/pjax/get-time'], ['class' => 'btn btn-sm btn-success']);?>
    <?php Pjax::end(); ?>
</div>

<div style="border: 1px solid #0000ff; padding: 20px; margin-top: 20px;">
    <?php Pjax::begin(); ?>
    <h3 style="text-decoration: underline">Обновление блока с изменение Url</h3>
    <h1>Сейчас:
        <?php
        if(isset($time)):
            ?>
            <?= $time ?>
            <?php
        endif;
        ?>
    </h1>
    <?= Html::a("Получить время с сервера", ['/pjax/get-time'], ['class' => 'btn btn-sm btn-success']);?>
    <?php Pjax::end(); ?>
</div>

