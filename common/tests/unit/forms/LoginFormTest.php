<?php

namespace common\tests\unit\forms;

use Yii;
use common\forms\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testLoginNoUser()
    {
        $form = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect('model should not login user', $form->login())->false();
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $form = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);

        expect('model should not login user', $form->login())->false();
        expect('error message should be set', $form->errors)->hasKey('password');
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
        $form = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        expect('model should login user', $form->login())->true();
        expect('error message should not be set', $form->errors)->hasntKey('password');
        expect('user should be logged in', Yii::$app->user->isGuest)->false();
    }
}
