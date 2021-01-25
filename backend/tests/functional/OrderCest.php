<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

/**
 * Class LoginCest
 */
class OrderCest
{
    /**
     * @param FunctionalTester $I
     */
    public function orderInsert(FunctionalTester $I)
    {
        $I->amOnPage('/order');
        $I->see('Orders');
        $I->click(['class' => 'btn-success']);
        
        $I->fillField('Orders[date]', '2021-11-21 00:15');
        $I->fillField('Orders[userId]', '2');
        $I->click('Save');

        $I->amOnPage('/order/view');
    }
}
