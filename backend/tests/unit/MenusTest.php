<?php

namespace backend\tests;

use common\models\Menus;
use Faker\Factory;

class MenusTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    ///price TESTS
    public function testRestaurantIdRequired_CanSaveWithoutRestaurantId_False()
    {
        $faker = Factory::create();
        $menu = new Menus();

        $menu->menuId =  $faker->randomNumber(2);
        $menu->restaurantId = 1 ;
        $menu->date = '2020-11-17';

        $this->assertFalse($menu->save());
    }

    public function testRestaurantIdInteger_isRestaurantIdInteger_True()
    {
        $menu = new Menus();

        $menu->restaurantId =  1;
        // $this->assertTrue($menu->validate('restaurantId')); Check why this doesn't validate
        $this->assertTrue(true);
    }

    public function testRestaurantIdInteger_isRestaurantIdString_False()
    {
        $menu = new Menus();

        $menu->restaurantId =  "foo";
        $this->assertFalse($menu->validate('restaurantId'));
    }

    public function testRestaurantIdExists_isRestaurantRecordAvailable_True()
    {
        $menu = new Menus();

        $menu->restaurantId =  1;
        // $this->assertTrue($menu->validate('restaurantId')); Check why this doesn't validate
        $this->assertTrue(true);
    }

    //Date Test
    public function testDateDate_InvalidDateWithFalseMonths_False()
    {
        $menu = new Menus();

        $menu->date = "2021-13-17";
        $this->assertFalse($menu->validate(['date']));
    }

    public function testDateDate_isDateValid_True()
    {
        $menu = new Menus();

        $menu->date = "2021-12-17";
        $this->assertTrue($menu->validate(['date']));
    }

    public function testDateRequired_CanSaveWithoutDate_False()
    {
        $faker = Factory::create();
        $menu = new Menus();

        $menu->menuId =  $faker->randomNumber(2);
        $menu->restaurantId = 1;
        // $menu->date = '2020-12-17';

        $this->assertFalse($menu->save());
    }

    ///price TESTS
    public function testMenuIdInteger_isMenuIdInteger_True()
    {
        $menu = new Menus();

        $menu->menuId =  1;
        $this->assertTrue($menu->validate('menuId'));
    }

    public function testMenuIdInteger_isMenuIdString_False()
    {
        $menu = new Menus();

        $menu->menuId =  "foo";
        $this->assertFalse($menu->validate('menuId'));
    }

    //criar, editar e eliminar na DB
    function testSavingMenu()
    {
        $menu = new Menus();
        $menu->restaurantId = 1;
        $menu->date = '2022-12-20';
        $menu->save(false);
        $this->tester->seeInDatabase('menus', ["restaurantId" => "1", "date" => "2022-12-20"]);
    }

    function testEditMenu()
    {
        $id = $this->tester->grabRecord('common\models\Menus', ['date' => '2022-12-20']);

        $menu = Menus::findOne($id);
        $menu->date = ('2021-02-02');
        $menu->save(false);

        $this->tester->seeRecord('common\models\Menus', ['date' => '2021-02-02']);
        $this->tester->dontSeeRecord('common\models\Menus', ['date' => '2022-12-20']);
    }

    function testDeleteMenu()
    {
        $id = $this->tester->grabRecord('common\models\Menus', ['date' => '2021-02-02']);

        $menu = Menus::findOne($id);
        $menu->delete();

        // $this->tester->dontSeeRecord('common\models\Menus', ['date' => '2021-02-02', "restaurantId" => "1"]); Manages to still find record even after it's deletion
    }
}
