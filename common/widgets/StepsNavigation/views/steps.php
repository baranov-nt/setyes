<?php
/**
 * Created by phpNT.
 * User: phpNT
 * Date: 08.02.2016
 * Time: 13:11
 */
/* @var $widget \common\widgets\StepsNavigation\StepsNavigation */
use yii\bootstrap\Html;
?>

<div class="row" style="padding: 0; margin: 0;">
    <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li id="linkStep1" role="presentation" class="<?= $widget->classLinkStep1 ?>" onclick="comeHere('#linkStep1')">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-book"></i>
                            </span>
                        </a>
                    </li>

                    <li id="linkStep2" role="presentation" class="<?= $widget->classLinkStep2 ?>" onclick="comeHere('#linkStep2')">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>
                    <li id="linkStep3" role="presentation" class="<?= $widget->classLinkStep3 ?>" onclick="comeHere('#linkStep3')">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                        </a>
                    </li>

                    <li id="linkStep4" role="presentation" class="<?= $widget->classLinkStep4 ?>" onclick="comeHere('#linkStep4')">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="<?= $widget->classContentStep1 ?>" role="tabpanel" id="step1" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep1 ?></h3>
                        <!--<p><?/*= $widget->contentStep1 */?></p>-->
                        <!--<ul class="list-inline pull-right">
                            <li>
                                <?/*= Html::a(Yii::t('app', 'Next'), ['/ad/real-estate/create'], ['class' => 'btn btn-primary next-step']) */?>
                            </li>
                        </ul>-->
                    </div>
                    <div class="<?= $widget->classContentStep2 ?>" role="tabpanel" id="step2" style="padding: 0 !important; margin-top: 10px !important;">
                        <h3><?= $widget->headerStep2 ?></h3>
                        <!--<p><?/*= $widget->contentStep2 */?></p>
                        <ul class="list-inline pull-right">
                            <li>
                                <?/*= Html::a(Yii::t('app', 'Back'), ['/ad/default/index'], ['class' => 'btn btn-default prev-step']) */?>
                            </li>
                            <li>

                            </li>
                        </ul>-->
                    </div>
                    <div class="<?= $widget->classContentStep3 ?>" role="tabpanel" id="step3">
                        <h3><?= $widget->headerStep3 ?></h3>
                        <p><?= $widget->contentStep3 ?></p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="<?= $widget->classContentStep4 ?>" role="tabpanel" id="complete">
                        <h3><?= $widget->headerStep4 ?></h3>
                        <p><?= $widget->contentStep4 ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
</div>

