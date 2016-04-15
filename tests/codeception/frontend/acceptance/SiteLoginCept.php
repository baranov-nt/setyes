<?php
use tests\codeception\frontend\AcceptanceTester;
$I = new AcceptanceTester($scenario);
$I->wantTo('выполнять действия (приемочный тест) и увидеть результат');
$I = new AcceptanceTester\SiteLoginSteps($scenario);
$I->wantTo('Убедится, что вход пользователя работает');

$I->amGoingTo('Отправить пустую форму');
//$I->see(Yii::t('app', 'Login'), '.title');
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
