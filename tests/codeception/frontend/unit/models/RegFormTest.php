<?php

namespace tests\codeception\frontend\unit\models;

use common\models\AuthAssignment;
use frontend\models\RegForm;
use tests\codeception\common\fixtures\AuthAssignmentFixture;
use tests\codeception\common\fixtures\UserPrivilegeFixture;
use tests\codeception\frontend\unit\DbTestCase;
use Codeception\Specify;
use common\models\User;

class RegFormTest extends DbTestCase
{

    use Specify;

    public function testCorrectFindUser()
    {
        // @var $modelRegForm \common\models\RegForm
        $modelRegForm = new RegForm([
            'country_id' => 182,
            'phone' => '79883332211',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password'
        ]);

        $user = $modelRegForm->reg();

        $this->assertInstanceOf('common\models\User', $user, 'user should be valid');

        expect('username should be correct', $user->phone)->equals('79883332211');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();
    }

    //public function testCorrectSignup()
    //{
        /*$model = new RegForm([
            'phone' => '79333333333',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'status' => 10,
            'country_id' => 182
        ]);

        $user = $model->reg();*/

        /*$this->assertInstanceOf('common\models\User', $user, 'user should be valid');

        expect('phone should be correct', $user->phone)->equals('79333333333');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();*/
    //}

    /*public function testNotCorrectSignup()
    {
        $model = new RegForm([
            'phone' => '79333333333',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'status' => 10,
            'country_id' => 182
        ]);

        expect('phone and email are in use, user should not be created', $model->reg())->null();
    }*/

    /*public function testCorrectDeleteUser()
    {
        // @var $modelUser \common\models\User
        $modelUser = User::findOne([
            'phone' => '79333333333',
            'email' => 'some_email@example.com',
        ]);
        pdd($modelUser);
        if($modelUser) {
            $modelUser->deleteUser($modelUser);
        }
    }*/

    public function fixtures()
    {
        return [
            'user' => [
                'class' => AuthAssignmentFixture::className(),
            ],
        ];
    }
}
