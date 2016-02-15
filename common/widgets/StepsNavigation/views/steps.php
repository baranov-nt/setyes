<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 08.02.2016
 * Time: 13:11
 */
/* @var $widget \common\widgets\StepsNavigation\StepsNavigation */
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

Modal::begin([
    'size' => 'modal-sm',
    'header' => '<h5>'.Yii::t('app', $widget->confirm).'</h5>',
    'toggleButton' => false,
    'closeButton' => false,
    'id' => 'confirm-step1',
]);

echo Html::a(Yii::t('app', 'Yes'), $widget->urlStep1, ['class' => 'btn btn-danger', 'style' => 'margin-right: 5px;']);
echo Html::button(Yii::t('app', 'No'), ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'aria-hidden' => 'true', 'style' => 'margin-left: 5px;']);

Modal::end();
?>

<div class="row" style="padding: 0; margin: 0;">
    <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li id="linkStep1" data-toggle="modal" data-target="<?= $widget->targetStep1 ?>" class="<?= $widget->classLinkStep1 ?>" onclick="comeHere('#linkStep1')"
                        style="outline: none;">
                        <a href="#step1"  aria-controls="step1" role="tab" title="<?= $widget->titleStep1 ?>" style="outline: none;">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-book"></i>
                            </span>
                        </a>
                    </li>

                    <li id="linkStep2" role="presentation" class="<?= $widget->classLinkStep2 ?>" onclick="comeHere('#linkStep2')">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="<?= $widget->titleStep2 ?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>
                    <li id="linkStep3" role="presentation" class="<?= $widget->classLinkStep3 ?>" onclick="comeHere('#linkStep3')">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="<?= $widget->titleStep3 ?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                        </a>
                    </li>

                    <li id="linkStep4" role="presentation" class="<?= $widget->classLinkStep4 ?>" onclick="comeHere('#linkStep4')">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="<?= $widget->titleStep4 ?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="<?= $widget->classContentStep1 ?> text-center" role="tabpanel" id="step1" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep1 ?></h3>
                        <!--<p><?/*= $widget->contentStep1 */?></p>-->
                    </div>
                    <div class="<?= $widget->classContentStep2 ?> text-center" role="tabpanel" id="step2" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep2 ?></h3>
                        <!--<p><?/*= $widget->contentStep2 */?></p>-->
                    </div>
                    <div class="<?= $widget->classContentStep3 ?> text-center" role="tabpanel" id="step3" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep3 ?></h3>
                        <!--<p><?/*= $widget->contentStep3 */?></p>-->
                    </div>
                    <div class="<?= $widget->classContentStep4 ?> text-center" role="tabpanel" id="complete" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep4 ?></h3>
                        <!--<p><?/*= $widget->contentStep4 */?></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
</div>

