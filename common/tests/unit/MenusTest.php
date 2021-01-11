<?php

namespace common\tests;

use common\models\Menus;
use Faker\Factory;

class MenusTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    ///price TESTS
    public function testRestaurantIdRequired_CanSaveWithoutRestaurantId_False()
    {
        $faker = Factory::create();
        $menu = new Menus();

        $menu->menuId =  $faker->randomNumber(2);
        // $menu->restaurantId = 1 ;
        $menu->date = '2020-11-17';

        $this->assertFalse($menu->save());
    }

    public function testRestaurantIdInteger_isRestaurantIdInteger_True()
    {
        $menu = new Menus();

        $menu->restaurantId =  1;
        $this->assertTrue($menu->validate('restaurantId'));
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
        $this->assertTrue($menu->validate('restaurantId'));
    }

    //Date Test
    public function testDateDate_InvalidDateWithFalseMonths_False()
    {
        $menu = new Menus();

        $menu->date = "2020-13-17";
        $this->assertFalse($menu->validate(['date']));
    }

    public function testDateDate_isDateValid_True()
    {
        $menu = new Menus();

        $menu->date = "2020-12-17";
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
}
