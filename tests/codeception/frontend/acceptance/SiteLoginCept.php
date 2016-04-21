<?php
use tests\codeception\frontend\AcceptanceTester;
use tests\codeception\frontend\_pages\SiteLoginPage;
use Faker\Factory;

$faker = Factory::create();
$I = new AcceptanceTester($scenario);
$I->comment('Проверка авторизации пользователей');
$loginPage = SiteLoginPage::openBy($I);
$I->wait(1);
$I->seeInTitle(Yii::t('app', 'Login'));
$I->seeElement('.main-login');
$I = new AcceptanceTester\SiteLoginSteps($scenario);
$I->comment('Отправка пустой формы');

$loginPage->login('', '');
$I->wait(1);
$I->see(Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('username')]), '.help-block');
$I->see(Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('password')]), '.help-block');
$I->comment('Отправка невнрных данных');
$loginPage->login($faker->email, 'неправильный пароль');
$I->wait(1);
$I->see(Yii::t('app', 'Wrong phone, email or password.'), '.help-block');
