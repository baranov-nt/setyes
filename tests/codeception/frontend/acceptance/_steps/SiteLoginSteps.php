<?php
namespace tests\codeception\frontend\AcceptanceTester;

class SiteLoginSteps extends \tests\codeception\frontend\AcceptanceTester
{
    /**
     *  Route to create employee form
     */
    public function amInCreateEmployeeUi()
    {
        $I = $this;
        $I->amOnPage('main/login');
        $I->click('Login');
        /*$I->waitForElement([
            'xpath' => "//form[contains(@id, 'Employee')]"
        ], 30);*/
    }

    /**
     * Return a empty array
     */
    function emptyEmployee()
    {
        return [];
    }

    /**
     * Fill the employee data form.
     * @param array $fieldsData Array of form id and data
     */
    function fillEmployeeDataForm($fieldsData)
    {
        $I = $this;
        foreach ($fieldsData as $key => $value)
            $I->fillField($key, $value);
    }

    /**
     * Submit the employee data form.
     */
    function submitEmployeeDataForm()
    {
        $I = $this;
        $I->click('Create');
    }

    /**
     * Return an array of employee fields based on the faker library
     */
    public function imagineEmployee()
    {
        $faker = \Faker\Factory::create();
        return [
            'Employee[name]' => $faker->name,
            'Employee[description]' => $faker->sentence(8),
        ];
    }
}