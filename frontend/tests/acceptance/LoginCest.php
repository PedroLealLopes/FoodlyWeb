<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class LoginCest
{

    public function checkLogin(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/login'));
        $I->fillField('LoginForm[username]', 'testaccount');
        $I->fillField('LoginForm[password]', 'test123123');
        $I->click('Login');
        $I->wait(3);
        $I->see('Home');
    }
}
