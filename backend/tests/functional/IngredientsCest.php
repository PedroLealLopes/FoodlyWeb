<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

/**
 * Class LoginCest
 */
class IngredientsCest
{
    /**
     * @param FunctionalTester $I
     */
    public function ingredientsInsert(FunctionalTester $I)
    {
        $I->amOnPage('/ingredients');
        $I->see('Ingredients');
        $I->click(['class' => 'btn-success']);
        
        $I->fillField('Ingredients[name]', 'Sal');
        $I->fillField('Ingredients[stock]', '2');
        $I->click('Save');

        $I->amOnPage('/ingredients/view');
    }
}
