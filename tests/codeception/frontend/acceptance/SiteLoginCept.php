<?php
use tests\codeception\frontend\AcceptanceTester;
use tests\codeception\frontend\_pages\SiteLoginPage;

$I = new AcceptanceTester($scenario);
$I->comment('Проверка авторизации пользователей');
$loginPage = SiteLoginPage::openBy($I);
$I->seeInTitle(Yii::t('app', 'Login'));
$I->seeElement('.main-login');
$I = new AcceptanceTester\SiteLoginSteps($scenario);
$I->comment('Отправка пустой формы');
$loginPage->login('', '');
$I->wait(1);
$I->see(Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('username')]), '.help-block');
$I->see(Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('password')]), '.help-block');
$I->comment('Отправка невнрных данных');
$loginPage->login('some', 'some');
$I->wait(1);
$I->see(Yii::t('app', 'Wrong phone, email or password.'), '.help-block');
//$I->see('Необходимо заполнить «Пароль».', '.help-block');
//$I->submitLoginDataForm();

/*$I->amGoingTo('Отправить пустую форму');
$I->seeInTitle('Войти');
$I->seeInTitle(Yii::t('app', 'Login'));*/
/*$I->amInCreateEmployeeUi();
$I->see('Create Employee');
$emptyEmployee = $I->emptyEmployee();
$I->fillEmployeeDataForm($emptyEmployee);
$I->submitEmployeeDataForm();

$I->expectTo('see validations errors');
$I->see('Name cannot be blank.');

$I->amGoingTo('try to create employee with valid fields');
$I->amInCreateEmployeeUi();
$I->see('Create Employee');
$first_employee = $I->imagineEmployee();
$I->fillEmployeeDataForm($first_employee);
$I->submitEmployeeDataForm();*/
