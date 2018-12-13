<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 30.10.2018
 * Time: 20:01
 */

namespace common\tests\unit\entities\User;

use Codeception\Test\Unit;
use common\entities\User;

class SignupTest extends Unit
{
    public function testSuccess()
    {
        $user = User::signup (
            $username = 'username',
            $email = 'email@site.com',
            $password = 'password'
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        //$this->assertEquals($password, $user->password_hash);
        $this->assertTrue($user->validatePassword($password));
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertTrue($user->isActive());


    }
}