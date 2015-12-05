<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use common\widgets\yii2I18nModule\models\SourceMessage;
use common\widgets\yii2I18nModule\Module;
use yii\widgets\ActiveForm;

$this->title = Module::t('Update') . ': ' . $model->message;
/*echo Breadcrumb::widget(['links' => [
    ['label' => Module::t('Translations'), 'url' => ['index']],
    ['label' => $this->title]
]]);*/
?>
<div class="message-update">
    <div class="message-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="field">
            <div class="ui grid">
                <?php foreach ($model->messages as $language => $message) : ?>
                    <div class="four wide column">
                        <?= $form->field($model->messages[$language], '[' . $language . ']translation')->label($language) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?= Html::submitButton(Module::t('Update'), ['class' => 'ui primary button']) ?>
        <?php $form::end(); ?>
    </div>
</div>
