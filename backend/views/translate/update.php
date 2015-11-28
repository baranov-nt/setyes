<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use common\widgets\Translate\models\SourceMessage;
use common\widgets\Translate\Module;
use yii\bootstrap\ActiveForm;

$this->title = Module::t('Update') . ': ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Module::t('Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<h2><?= Module::t('Source message') ?></h2>
<p><?= Html::encode($model->message) ?></p>
<?php $form = ActiveForm::begin(); ?>
<?php foreach ($model->messages as $language => $message) : ?>
    <?= $form->field($model->messages[$language], '[' . $language . ']translation')->label($language) ?>
<?php endforeach; ?>
<?= Html::submitButton(Module::t('Update')) ?>
<?php $form::end(); ?>
<?php
//echo Yii::t('newSome', 'Translations');
