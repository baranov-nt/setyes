<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use common\widgets\yii2I18nModule\models\SourceMessage;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Update') . ': ' . $model->message;
/*echo Breadcrumb::widget(['links' => [
    ['label' => Yii::t('app', 'Translations'), 'url' => ['index']],
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
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'ui primary button']) ?>
        <?php $form::end(); ?>
    </div>
</div>
