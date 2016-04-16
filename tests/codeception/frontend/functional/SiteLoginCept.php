<?php
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\frontend\_pages\SiteLoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('Войти на страницу входа пользователя.');
SiteLoginPage::openBy($I);
$I->seeElement('.main-login');