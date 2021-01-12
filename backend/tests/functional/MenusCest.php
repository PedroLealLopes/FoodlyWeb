<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

/**
 * Class LoginCest
 */
class MenusCest
{
    /**
     * @param FunctionalTester $I
     */
    public function menusInsert(FunctionalTester $I)
    {
        $I->amOnPage('/menus');
        $I->see('Menuses');
        $I->click(['class' => 'btn-success']);
        
        $I->fillField('Menus[restaurantId]', '2');
        $I->fillField('Menus[date]', '2021-11-25');
        $I->click('Save');

        $I->amOnPage('/menus/view');
    }
}
