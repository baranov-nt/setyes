<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.04.2016
 * Time: 17:14
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class UserPrivilegeFixture extends ActiveFixture
{
    public $modelClass = 'common\models\UserPrivilege';
    public $dataFile = '@tests/codeception/common/fixtures/data/userPrivilege.php';
    public $depends = ['tests\codeception\common\fixtures\UserProfileFixture'];
}