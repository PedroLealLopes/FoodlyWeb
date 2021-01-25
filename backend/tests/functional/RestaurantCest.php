<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

/**
 * Class LoginCest
 */
class RestaurantCest
{
    /**
     * @param FunctionalTester $I
     */
    public function restaurantInsert(FunctionalTester $I)
    {
        $I->amOnPage('/restaurant');
        $I->see('Restaurants');
        $I->click(['class' => 'btn-success']);
        
        $I->fillField('Restaurant[location]', 'Foo');
        $I->fillField('Restaurant[name]', 'Foo');
        $I->fillField('Restaurant[maxPeople]', '20');
        $I->fillField('Restaurant[currentPeople]', '2');
        $I->fillField('Restaurant[openingHour]', '00:00:00');
        $I->fillField('Restaurant[closingHour]', '00:00:12');
        $I->fillField('Restaurant[allowsPets]', '1');
        $I->fillField('Restaurant[hasVegan]', '1');
        $I->fillField('Restaurant[description]', 'Foobar');
        $I->fillField('Restaurant[wifiPassword]', '2231sdff');
        $I->click('Save');

        $I->amOnPage('/restaurant/view');
    }
}
