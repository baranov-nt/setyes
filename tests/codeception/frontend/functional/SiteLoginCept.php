<?php
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\frontend\_pages\SiteLoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('выполнять действия (функциональный тест) и увидеть результат');
$I->wantTo('убедится, что страница логин открывается');
SiteLoginPage::openBy($I);
$I->see(Yii::t('app', 'Login'), '.title');
