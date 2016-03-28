<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 05.10.2015
 * Time: 18:16
 */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
?>
<h3 style="text-decoration: underline">Изменение элемента с помощью формы в виджете</h3>
    <h1>Отчество</h1>
    <?php
    if(isset($modelProfile)):
        ?>
        <?php $form = ActiveForm::begin([
        'action' => 'update-middle-name',
        'id' => 'pjax-widget-form',
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