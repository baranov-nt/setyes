<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2016
 * Time: 12:15
 */

namespace tests\codeception\frontend\_pages;

use yii\codeception\BasePage;
use common\models\LoginForm;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester | \tests\codeception\frontend\FunctionalTester | \tests\codeception\backend\AcceptanceTester| \tests\codeception\backend\FunctionalTester $actor
 */
class SiteLoginPage extends BasePage
{
    public $route = 'main/login';

    public function login($username, $password)
    {
        $this->actor->fillField('input[name="LoginForm[username]"]', $username);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('login-button');
    }

    public function getLoginFormAttribute($attribute)
    {
        $modelLoginForm = new LoginForm();
        $attribute = $modelLoginForm->getAttributeLabel($attribute);
        return $attribute;
    }
}