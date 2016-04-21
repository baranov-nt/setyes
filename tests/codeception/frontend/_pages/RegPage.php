<?php

namespace tests\codeception\frontend\_pages;

use \yii\codeception\BasePage;

/**
 * Represents signup page
 * @property \tests\codeception\frontend\AcceptanceTester | \tests\codeception\frontend\FunctionalTester $actor
 */
class RegPage extends BasePage
{

    public $route = 'main/reg';

    /**
     * @param array $signupData
     */
    public function submit(array $signupData)
    {
        foreach ($signupData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="RegForm[' . $field . ']"]', $value);
        }
        $this->actor->click('signup-button');
    }
}
